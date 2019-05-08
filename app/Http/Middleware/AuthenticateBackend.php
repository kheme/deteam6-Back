<?php
/**
 * Middleware to check backend guard
 *
 * PHP version 7
 *
 * @category  Middleware
 * @package   DigitalExplorers
 * @author    Okiemute Omuta <omuta.okiemute@gmail.com>
 
 * @copyright 2019 Okiemute Omuta. All rights reserved.
 * @license   Unauthorized copying of this file, via any medium is highly prohibited.
 * @link      https://twitter.com/kheme
 */
namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

/**
 * Main AuthenticateBackend Class
 *
 * @category  Middleware
 * @package   DigitalExplorers
 * @author    Okiemute Omuta <omuta.okiemute@gmail.com>
 
 * @copyright 2019 Okiemute Omuta. All rights reserved.
 * @license   Unauthorized copying of this file, via any medium is highly prohibited.
 * @link      https://twitter.com/kheme
 */
class AuthenticateBackend extends Middleware
{
    /**
     * Check backend guard
     *
     * @param Request $request HTTP request
     * @param Closure $next    Laravel closure
     * 
     * @author Okiemute Omuta <omuta.okiemute@gmail.com>
     * 
     * @return string
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if (auth()->user()->tokenCan('access_backend')) {
            return $next($request);
        }

        return accessDenied();
    }
}
