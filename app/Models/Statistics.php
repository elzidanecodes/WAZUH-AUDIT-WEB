<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Statistics extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'statistik';
    public $timestamps = false;

    protected $fillable = [
        'mttd_menit',
        'mttr_menit',
        'total_event',
        'dihitung_pada'
    ];
}
