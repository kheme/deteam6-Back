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

Route::get('gender', 'DashboardController@gender');
Route::get('user_agents', 'DashboardController@userAgents');
Route::get('referer', 'DashboardController@referer');
Route::get('sites', 'DashboardController@sites');