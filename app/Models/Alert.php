<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;

class Alert extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'alerts';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'timestamp',
        'month',
        'day',
        'time',
        'host',
        'process',
        'pid',
        'message',
        'raw',
        'source'
    ];

}
