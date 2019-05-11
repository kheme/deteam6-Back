<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

class Impression extends Model
{
    use Rememberable;

    // public $timestamps = false;
    protected $connection = 'hack';
    protected $table = 'impression';
    protected $fillable = [
        'profile_id', 'event_time', 'referer_id', 'referer_url', 'user_agent_id'
    ];
}