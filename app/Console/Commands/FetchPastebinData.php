<?php

namespace App\Console\Commands;

use App\Mail\NewPastebinsNotification;
use App\Models\PastebinData;
use App\Models\PastebinError;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class FetchPastebinData extends Command
{
    const MAIL_ENV_VARS = [
        'MAIL_MAILER',
        'MAIL_HOST',
        'MAIL_PORT',
        'MAIL_ENCRYPTION',
        'MAIL_USERNAME',
        'MAIL_PASSWORD',
        'MAIL_FROM_ADDRESS',
        'MAIL_FROM_NAME',
        'MAIL_TO',
        'PASTEBIN_URLS',
        'REGEX_PATTERN'
    ];
    const NO_REGEX_PATTERN_MSG = 'No REGEX_PATTERN defined in the .env file';
    protected $signature = 'fetch:pastebins';
    protected $description = 'Fetch data from predefined Pastebin raw URLs and save it to the SQLite database';

    public function handle()
    {
        $this->checkEnvVars();
        $pattern = env('REGEX_PATTERN') ?? null;

        $newPastebins = [];

        foreach ($this->getPastebinUrls() as $url) {
            try {
                $response = Http::withOptions(['verify' => false])->get($url);
    
                 if ($response->successful()) {                
                    preg_match_all($pattern, $response->body(), $matches);
                
                    if (!empty($matches[0])) {
                        $latestMatch = trim(end($matches[0]));             

                        $this->info("Data fetched from: $url");
                        // check if content and url already exists in the database, if still not exists save it
                        $exists = PastebinData::where('url', $url)->where('content', $latestMatch)->exists();
                        if (!$exists) {
                            // check if another pastebin url already has the same content
                            $existingContentPastebins = PastebinData::where('content', $latestMatch)->get();
                            $newPastebins[] = [
                                'url' => $url,
                                'content' => $latestMatch,
                                'existing_content_pastebins' => $existingContentPastebins,
                            ];

                            // Save the new pastebin url/content to database
                            PastebinData::create([
                                'url' => $url,
                                'content' => $latestMatch,
                            ]);
                        }
                    } else {
                        $this->error("No matching content found in the response from: $url");
                        PastebinError::create([
                            'url' => $url,
                            'error' => 'No matching content found',
                        ]);
                    }           
                } else {
                    $this->error("Failed to fetch data from: $url");
                    PastebinError::create([
                        'url' => $url,
                        'error' => 'Failed to fetch data',
                    ]);
                }
            } catch (\Exception $e) {
                $this->error("Failed to fetch data from: $url");
                PastebinError::create([
                    'url' => $url,
                    'error' => $e->getMessage(),
                ]);
            }
        
        }

        // Send email notification if new pastebins are found
        if (count($newPastebins) > 0) {
            $this->sendEmail($newPastebins);
        }
    }

    private function getPastebinUrls(): array
    {
        $pastebins = explode(',', env('PASTEBIN_URLS'));
        if (count($pastebins) === 0) {
            $this->error('No PASTEBIN_URLS defined in the .env file');
            PastebinError::create([
                'url' => '',
                'error' => 'No PASTEBIN_URLS defined in the .env file',
            ]);
        }

        $this->checkUrls($pastebins);

        return $pastebins ?? [];
    }

    private function checkUrls(array $urls): void
    {
        foreach ($urls as $url) {
            if (!filter_var($url, FILTER_VALIDATE_URL) || !preg_match('/^https?:\/\//', $url)) {
                $this->error("Invalid URL: $url");
                PastebinError::create([
                    'url' => $url,
                    'error' => 'Invalid URL',
                ]);
                throw new \Exception("Invalid URL: $url", 412);
            }
        }
    }

    private function sendEmail(array $newPastebins): void
    {
        $mailto = env('MAIL_TO');
        $this->info('New pastebins found, sending email notification');

        $limit = env('LATEST_PASTEBINS_LIMIT', 10); // Default to 10 if not set in .env
        if (!is_numeric($limit) || $limit <= 0) {
            $limit = 10; // Fallback to 10 if the limit is not a positive number
        }
        $latestPastebins = PastebinData::orderBy('id', 'desc')->limit($limit)->get() ?? [];
        $datetime = Carbon::now()->format('Y-m-d H:i:s');
     
        Mail::to($mailto)->send(
            new NewPastebinsNotification(
                $newPastebins, 
                $latestPastebins->toArray(), 
                $datetime
                )
            );
    }

    private function checkEnvVars(): void
    {
        foreach (self::MAIL_ENV_VARS as $envVar) {
            if (!env($envVar)) {
                $this->error("No $envVar defined in the .env file");
                PastebinError::create([
                    'url' => '',
                    'error' => "No $envVar defined in the .env file",
                ]);
                throw new \Exception("No $envVar defined in the .env file", 412);
            }
        }
    }
}