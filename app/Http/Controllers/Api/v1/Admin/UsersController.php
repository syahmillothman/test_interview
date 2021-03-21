<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $roles = $request->has('roles') ? array_map('intval', explode(',', $request->get('roles'))) : Role::pluck('id')->all();
        
        $users = User::latest()
            // ->byRoles($roles)
            ->get();

        return $this->getResponseFactory()->giveSuccessResponse($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->merge(['role_id' => $request->input('role.id'), 'password' => Hash::make($request->password)]);
        //just set default password to password!
        $payload = $request->only('email', 'name', 'role_id', 'password');

        $user = User::create($payload);
        $user->load('role');

        return $this->getResponseFactory()->giveSuccessResponse($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        try {

            $user = User::findOrFail($id);
            $request->merge(['role_id' => $request->input('role.id')]);
            $payload = $request->only('email', 'name', 'role_id');
            $user->update($payload);
            $user->load('role');

            return $this->getResponseFactory()->giveSuccessResponse($user, Response::HTTP_OK, 'User successfully saved.');

        } catch (ModelNotFoundException $e) {

            return $this->getResponseFactory()->giveErrorResponse('Resource not found.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $user = User::findOrFail($id);
            $snapshot = $user;
            $user->delete();

            //instead of we returning no content response to frontend.
            //we give old snapshot to frontend response for further usage.eg: used to display message.
            return $this->getResponseFactory()->giveSuccessResponse($snapshot, Response::HTTP_OK, 'User successfully removed.');

        } catch (ModelNotFoundException $e) {

            return $this->getResponseFactory()->giveErrorResponse('Resource not found.');
        }
    }
}
