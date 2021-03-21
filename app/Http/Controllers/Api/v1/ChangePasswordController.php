<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class ChangePasswordController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        try {

            $user = $this->getCurrentUser();
            /**
             * we validate password confirm on frontend instead of backend
             * This method giving more robustness to frontend manipulating errors.
             */
            Validator::make($request->all(), [
                // 'current_password'     => 'required',
                'password' => 'required',
                // 'pasword_confirmation' => 'required',
            ])
                ->validate();

            $request->merge(['password' => Hash::make($request->password)]);
            $user->update($request->only('password'));

            //notify user for password changed event.
            return $this->getResponseFactory()->giveSuccessResponse($user, Response::HTTP_OK, 'Password successfully changed.');

        } catch (ValidationException | Exception $e) {

            return $this->getResponseFactory()->giveErrorResponse(
                $request->all(), Response::HTTP_BAD_REQUEST, $e->getMessage()
            );
        }
    }
}
