<?php
/**
 * Frontend controller for users
 *
 * PHP version 7
 *
 * @category  Contoller
 * @package   Fleetrak
 * @author    Okiemute Omuta <omuta.okiemute@gmail.com>
 * @copyright 2019 Okiemute Omuta. All rights reserved.
 * @license   Unauthorized copying of this file, via any medium is highly prohibited.
 * @link      https://twitter.com/kheme
 */
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Hash;
use DB;

use App\Models\{Dimension, Impression, Metric, ProfileMetric, Referer, UserAgent};

class DashboardController extends Controller
{
    protected function gender(Request $request)
    {
        $male = ProfileMetric::selectRaw("metric.value AS value")
            ->join('metric', 'metric.id', 'profile_metric.metric_id')
            ->where('metric.value', 'male')
            ->remember(1000);

        $female = ProfileMetric::selectRaw("metric.value AS value")
            ->join('metric', 'metric.id', 'profile_metric.metric_id')
            ->where('metric.value', 'female')
            ->remember(1000);
        
        return ['male' => $male->count(), 'female' => $female->count()];
    }

    protected function userAgents(Request $request)
    {
        $browsers = UserAgent::get()->remember(1000)->take(100);
        
        return $browsers;
    }

    protected function sites(Request $request)
    {
        $sites = Impression::selectRaw(
                'url, count(referer_id) as visits'
            )
            ->leftJoin('referer', 'referer.id', 'referer_id')
            ->groupBy('referer_id')
            ->orderBy('visits', 'desc')
            ->take(10)
            ->remember(1000)
            ;

        if ($request->gender) {
            $sites = $sites->join('profile_metric', 'profile_metric.profile_id', 'impression.profile_id')
                ->join('metric', 'metric.id', 'profile_metric.metric_id')
                ->where('metric.value', $request->gender);
        }
        
        return $sites->get();
    }

}
