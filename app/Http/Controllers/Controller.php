<?php

namespace App\Http\Controllers;

use App\Helpers\AppUtilityHelper;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getResponseFactory()
    {
        return (new AppUtilityHelper);
    }

    /**
     * @param $guard
     */
    public function getCurrentUser($guard = 'api')
    {
        return auth()->guard($guard)->user();
    }
}
