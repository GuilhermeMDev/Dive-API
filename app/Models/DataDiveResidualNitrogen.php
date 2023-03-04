<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataDiveResidualNitrogen extends Model
{
    use HasFactory;

    protected $table = 'data_dive_residual_nitrogens';

    protected $fillable = [
        'repetLetter',
        'residualNitrogenTime'
    ];

    protected $casts = [
        'residualNitrogenTime' => 'array'
    ];
}
