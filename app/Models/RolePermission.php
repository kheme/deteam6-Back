<?php
/**
 * Role to permissions mapping model
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
 * Main RolePermission Class
 *
 * @category  Model
 * @package   DigitalExplorers
 * @author    Okiemute Omuta <omuta.okiemute@gmail.com>
 * @copyright 2019 Okiemute Omuta. All rights reserved.
 * @license   Unauthorized copying of this file, via any medium is highly prohibited.
 * @link      https://twitter.com/kheme
 */
class RolePermission extends Model
{

    protected $fillable = ['role_id', 'permission_id'];

}