<?php
/**
 * Helper functions
 * 
 * PHP version 7
 *
 * @category  Helper
 * @package   DigitalExplorers
 * @author    Okiemute Omuta <omuta.okiemute@gmail.com>
 * @author    Andyson Utomudo <a.utomudo@concept-nova.com>
 * @copyright 2019 Okiemute Omuta. All rights reserved.
 * @license   Unauthorized copying of this file, via any medium is highly prohibited.
 * @link      https://twitter.com/kheme
 */


use App\Notifications\AlertNotification;
use App\Mail\SendTankAlert;
use App\Mail\SendVehicleAlert;

use App\Models\Permission;

use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Return "Access denied" or other message
 * 
 * @param string $message (Optional) Message to display on redirect
 * 
 * @author Okiemute Omuta <omuta.okiemute@gmail.com>
 *
 * @return redirect
 */
function accessDenied($message = null)
{
    $final_message = "Access denied";

    if ($message) {
        $final_message = "$final_message: $message";
    }
    
    $return = jsonErrorResponse($final_message, 403);

    return $return;
}

/**
 * Checks if there is internet connection
 * 
 * @author Okiemute Omuta <omuta.okiemute@gmail.com>
 *
 * @return boolean
 */
function isOnline()
{
    $connected = checkdnsrr("google.com");

    if ($connected) {
        return true;
    }

    return false;
}

/**
 * Checks if there is no internet connection
 * 
 * @author Okiemute Omuta <omuta.okiemute@gmail.com>
 *
 * @return boolean
 */
function isOffline()
{
    $connected = checkdnsrr("google.com");

    if ($connected) {
        return false;
    }

    return true;
}


/**
 * Simplified CURL function
 * 
 * @param string $url API URL
 * 
 * @author Okiemute Omuta <omuta.okiemute@gmail.com>
 *
 * @return string
 */
function curl($url)
{
    $return = null;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    
    $return = curl_exec($ch);

    curl_close($ch);

    return $return;
}

/**
 * Returns error response as json
 * 
 * @param string $message Optional error message
 * @param mixed  $code    Response code to attach to the response
 * 
 * @author Okiemute Omuta <omuta.okiemute@gmail.com>
 *
 * @return string
 */
function jsonErrorResponse($message = 'Error', $code = 400)
{
    $data = [
        'success' => false,
        'code'    => $code,
    ];

    if (is_array($message)) {
        $data = array_merge($data, $message);
    } else {
        $data['message'] = $message;
    }
    
    return
        response()
        ->json($data, $code);
}

/**
 * Returns success response as json
 * 
 * @param string $message Optional success message
 * @param mixed  $code    Response code to attach to the response
 * 
 * @author Okiemute Omuta <omuta.okiemute@gmail.com>
 *
 * @return string
 */
function jsonSuccessResponse($message = 'Success', $code = 200)
{
    $data = [
        'success' => true,
        'code'    => $code,
    ];

    if (is_array($message)) {
        $data['data'] = $message;
    } else {
        $data['message'] = $message;
    }
    
    return
        response()
        ->json($data, $code);
}

/**
 * Checks if a user has the required permission for a given module
 * 
 * @param model  $user       Model of user of interest
 * @param string $permission CRUD permission to check Eg. view
 * 
 * @author Okiemute Omuta <omuta.okiemute@gmail.com>
 *
 * @return string
 */
function userHasPermission($user, $permission)
{
    $has_permission = $user->permissions()
        ->selectRaw('permissions.id')
        ->where('permissions.name', $permission)
        ->count();
    
    return (boolean) $has_permission;
}

/**
 * Checks if a user lacks the required permission for a given module
 * 
 * @param model  $user       Model of user of interest
 * @param string $permission CRUD permission to check Eg. view
 * 
 * @author Okiemute Omuta <omuta.okiemute@gmail.com>
 *
 * @return string
 */
function userLacksPermission($user, $permission)
{
    $has_permission = $user->permissions()
        ->selectRaw('permissions.id')
        ->where('permissions.name', $permission)
        ->count();
    
    return (boolean) !$has_permission;
}