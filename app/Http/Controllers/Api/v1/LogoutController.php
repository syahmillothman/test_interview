<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    /**
     * @param Request $request
     */
    public function __invoke(Request $request)
    {
        try {
            //validate request
        } catch (Exception $e) {

        }
    }
}
