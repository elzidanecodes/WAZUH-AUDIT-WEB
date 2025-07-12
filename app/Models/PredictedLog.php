<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class PredictedLog extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'predicted_logs';
    public $timestamps = false;

    protected $fillable = [
        'timestamp',
        'decoder',
        'description',
        'predicted_label'
    ];
}