<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PastebinData extends Model
{
    use HasFactory;

    protected $table = 'pastebins';

    protected $fillable = [
        'url',
        'content',
        'created_at',
        'updated_at',
    ];
}