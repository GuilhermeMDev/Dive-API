<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataDiveInterval extends Model
{
    use HasFactory;

    protected $table = 'data_dive_intervals';

    protected $fillable = [
        'groupLetter',
        'minTime',
        'maxTime',
        'repetLetter',
    ];

}
