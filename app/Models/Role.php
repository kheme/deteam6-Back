<?php
/**
 * Roles model
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

/**
 * Main Role Class
 *
 * @category  Model
 * @package   DigitalExplorers
 * @author    Okiemute Omuta <omuta.okiemute@gmail.com>
 * @copyright 2019 Okiemute Omuta. All rights reserved.
 * @license   Unauthorized copying of this file, via any medium is highly prohibited.
 * @link      https://twitter.com/kheme
 */
class Role extends Model
{

    protected $fillable = ['name'];

    /**
     * Return the permissions this role has.
     * For use with public data
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