<?php
/**
 * Users model
 *
 * PHP version 7
 *
 * @category  Model
 * @package   DigitalExplorers
 * @author    Okiemute Omuta <omuta.okiemute@gmail.com>
 * @copyright 2019 Okiemute Omuta. All rights reserved.
 * @license   Unauthorized copying of this file, via any medium is highly prohibited.
 * @link      https://twitter.com/kheme
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * Main User Class
 *
 * @category  Model
 * @package   DigitalExplorers
 * @author    Okiemute Omuta <omuta.okiemute@gmail.com>
 * @copyright 2019 Okiemute Omuta. All rights reserved.
 * @license   Unauthorized copying of this file, via any medium is highly prohibited.
 * @link      https://twitter.com/kheme
 */
class User extends Authenticatable
{

    use HasApiTokens, Notifiable;
    
    protected $table    = 'users';
    protected $hidden   = ['password'];
    protected $dates    = ['email_verified_at'];
    protected $casts    = ['email_verified_at' => 'datetime'];
    protected $fillable = [
        'role_id', 'name', 'email', 'email_verified_at', 'password', 'remember_token'
    ];

    /**
     * Return the role this user belongs to.
     * For use with private data.
     *
     * @author Okiemute Omuta <omuta.okiemute@gmail.com>
     *
     * @return model
     */
    public function role()
    {
        return
            $this->belongsTo('App\Models\Role', 'role_id', 'id');
    }

    /**
     * Return the permissions this user has.
     * For use with public data.
     *
     * @author Okiemute Omuta <omuta.okiemute@gmail.com>
     *
     * @return model
     */
    public function permissions()
    {
        return
            $this->hasManyThrough(
                'App\Models\Permission', 'App\Models\RolePermission',
                'role_id', 'id',
                'id', 'permission_id'
            );
    }

}