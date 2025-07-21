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
        'predicted_label',
        'source'
    ];

    // Laravel Accessor: label dalam format lowercase dengan underscore
    public function getLabelAttribute(): string
    {
        return strtolower(str_replace(' ', '_', $this->predicted_label));
    }

    public function getLabelTextAttribute()
    {
        return match ($this->label) {
            'brute_force' => 'Brute Force',
            'ddos' => 'DDoS',
            'normal' => 'Normal',
            default => ucfirst(str_replace('_', ' ', $this->label))
        };
    }

    public function getBadgeClassAttribute()
    {
        return match ($this->label) {
            'brute_force' => 'bg-yellow-200 text-yellow-800 text-xs font-medium px-2 py-1 rounded',
            'ddos' => 'bg-red-200 text-red-800 text-xs font-medium px-2 py-1 rounded',
            'normal' => 'bg-green-200 text-green-800 text-xs font-medium px-2 py-1 rounded',
            default => 'bg-gray-200 text-gray-800'
        };
    }
}