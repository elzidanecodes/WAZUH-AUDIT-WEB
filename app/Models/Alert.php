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
        'alert_id',
        'timestamp',
        'agent_id',
        'agent_name',
        'manager_name',
        'rule_id',
        'level',
        'rule_description',
        'full_log'
    ];
}
