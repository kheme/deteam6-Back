<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

class UserAgent extends Model
{
    use Rememberable;

    // public $timestamps = false;
    protected $connection = 'hack';
    protected $table = 'user_agent';
    protected $fillable = [
        'device_family', 'os_family', 'os_major_version', 'user_agent_family',
        'user_agent_major', 'device_brand', 'user_agent_string', 'device_type',
        'hash'
    ];
}