<?php
/**
 * Controller for frontend homepage
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
namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Main PagesController Class
 *
 * @category  Contoller
 * @package   DigitalExplorers
 * @author    Okiemute Omuta <omuta.okiemute@gmail.com>
 * @copyright 2019 Okiemute Omuta. All rights reserved.
 * @license   Unauthorized copying of this file, via any medium is highly prohibited.
 * @link      https://twitter.com/kheme
 */
class PagesController extends Controller
{

    /**
     * Show the application homepage
     *
     * @return view
     */
    public function showHomePage()
    {
        return view('welcome');
    }
}
