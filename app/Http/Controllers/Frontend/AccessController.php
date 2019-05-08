<?php
/**
 * Controller for frontend access
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
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Validator;

use User;

/**
 * Main AccessController Class
 *
 * @category  Contoller
 * @package   DigitalExplorers
 * @author    Okiemute Omuta <omuta.okiemute@gmail.com>
 * @copyright 2019 Okiemute Omuta. All rights reserved.
 * @license   Unauthorized copying of this file, via any medium is highly prohibited.
 * @link      https://twitter.com/kheme
 */
class AccessController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Log user in
     * 
     * @param Request $request HTTP request
     *
     * @return void
     */
    public function doLogin(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [ 
                'email'    => 'required|email', 
                'password' => 'required', 
            ]
        );

        if ($validator->fails()) { 
            return jsonErrorResponse('Please provide login credentials');
        }

        $email    = $request->email;
        $password = $request->password;

        $logged_id = auth()->attempt(
            [
                'email'    => $email,
                'password' => $password,
            ], true
        );

        if ($logged_id) {
            $user = auth()->user();
            
            $new_token = $user->createToken('DigitalExplorers', ['access_frontend'])
                ->accessToken;

            $data = [
                'token' => $new_token
            ];

            return jsonSuccessResponse($data);
        } else {
            return jsonErrorResponse('Invalid login credentials');
        }
    }

    /**
     * Log user out
     * 
     * @param Request $request HTTP request
     *
     * @return void
     */
    public function doLogout(Request $request)
    {
        $auth_user = auth()->user();

        $auth_user->token()->revoke();
         
        return jsonSuccessResponse('Logged out successfully!');
    }

}
