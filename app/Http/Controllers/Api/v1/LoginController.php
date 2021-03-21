<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    /**
     * @param Request $request
     */
    public function __invoke(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try
        {
            Validator::make($request->all(), [
                'email' => 'required', 'password' => 'required',
            ])
                ->validate();

            if (Auth::attempt($credentials)) {

                $token = auth()->user()->createToken('demo_app', ['*'])->accessToken;

                return $this->getResponseFactory()
                    ->giveSuccessResponse(['token' => $token]);

            }

            return $this->getResponseFactory()
                ->giveErrorResponse($request->all(), Response::HTTP_FORBIDDEN, 'Wrong username or password.');

        } catch (ValidationException | Exception $e) {

            return $this->getResponseFactory()
                ->giveErrorResponse($e->getMessage());
        }
    }
}
