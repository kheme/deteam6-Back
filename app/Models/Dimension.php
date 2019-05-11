<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

class Dimension extends Model
{
    use Rememberable;

    // public $timestamps = false;
    protected $connection = 'hack';
    protected $table = 'dimension';
    protected $fillable = [
        'category', 'name', 'description', 'type', 'cardinality'
    ];
}