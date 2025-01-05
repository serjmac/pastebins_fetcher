<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewPastebinsNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $newPastebins;
    public $latestPastebins;
    public $datetime;

    /**
     * Create a new message instance.
     */
    public function __construct($newPastebins, $latestPastebins, $datetime)
    {
        $this->newPastebins = $newPastebins;
        $this->latestPastebins = $latestPastebins;
        $this->datetime = $datetime;
    }

    public function build()
    {        
        return $this->view('emails.new_pastebins')
                    ->with('newPastebins', $this->newPastebins)
                    ->with('datetime', $this->datetime)
                    ->with('latestPastebins', $this->latestPastebins);
    }
}
