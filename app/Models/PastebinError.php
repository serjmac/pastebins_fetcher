<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PastebinError extends Model
{
    use HasFactory;

    protected $table = 'pastebin_errors';

    protected $fillable = [
        'url',
        'error',
        'created_at',
        'updated_at',
    ];
}
