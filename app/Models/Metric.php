<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

class Metric extends Model
{
    use Rememberable;

    // public $timestamps = false;
    protected $connection = 'hack';
    protected $table = 'metric';
    protected $fillable = [
        'dimension_id', 'value'
    ];
}