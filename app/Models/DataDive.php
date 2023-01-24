<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\Table;

class DataDive extends Model
{
    use HasFactory;

    protected $table = 'data_dives';

    protected $fillable = [
        'minfsw',
        'maxfsw',
        'unlimited',
        'noStopLimit',
        'values',
    ];
    protected $casts = [
        'values' => 'array'
    ];
}
