<?php
/**
 * Password resets model
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
 * Main PasswordReset Class
 *
 * @category  Model
 * @package   DigitalExplorers
 * @author    Okiemute Omuta <omuta.okiemute@gmail.com>
 * @copyright 2019 Okiemute Omuta. All rights reserved.
 * @license   Unauthorized copying of this file, via any medium is highly prohibited.
 * @link      https://twitter.com/kheme
 */
class PasswordReset extends Model
{

    protected $fillable = ['email', 'token'];

}