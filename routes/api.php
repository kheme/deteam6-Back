<?php
/**
 * API routes
 *
 * PHP version 7
 *
 * @category  Contoller
 * @package   DigitalExplorers
 * @author    Okiemute Omuta <omuta.okiemute@gmail.com>
 
 * @copyright 2019 Okiemute Omuta. All rights reserved.
 * @license   Unauthorized copying of this file, via any medium is highly prohibited.
 * @link      https://twitter.com/kheme
 */
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', 'HomeController@showHomepage');

Route::post('app/login', 'Frontend\AccessController@doLogin');

Route::middleware('auth:api')->prefix('app')->group(
    function () {
        Route::get('/', 'Frontend\AccessController@showData');
        
        Route::post('logout', 'Frontend\AccessController@doLogout');
        
        Route::middleware('auth:api')->prefix('users')->group(
            function () {
                Route::get(
                    '{user_id?}',
                    'Frontend\UserController@viewUsers'
                );
                
                Route::put(
                    '/',
                    'Frontend\UserController@createUser'
                );
            }
        );

        Route::middleware('auth:api')->prefix('roles')->group(
            function () {
                Route::get(
                    '{role_id?}',
                    'Frontend\RollController@viewRoles'
                );

                Route::post(
                    '{role_id}',
                    'Frontend\RollController@updateRole'
                );

                Route::delete(
                    '{role_id}',
                    'Frontend\RollController@deleteRole'
                );
                
                Route::put(
                    '/',
                    'Frontend\RollController@createRole'
                );
                
                Route::get(
                    '{role_id}/permissions',
                    'Frontend\RollController@viewRolePermissions'
                );
            }
        );
    }
);