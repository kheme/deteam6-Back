<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

class ProfileMetric extends Model
{
    use Rememberable;

    // public $timestamps = false;
    protected $connection = 'hack';
    protected $table = 'profile_metric';
    protected $fillable = [
        'profile_id', 'metric_id'
    ];
}