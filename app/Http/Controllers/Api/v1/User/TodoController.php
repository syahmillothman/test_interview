<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\Todo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;



class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $todos = Todo::latest()->get();
        return $this->getResponseFactory()->giveSuccessResponse($todos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $todo = Todo::create([
            'body' => request('body'),
            'is_complete' => request('is_complete'),
            'users_id' => request('users_id'),
            // 'created_at' => date("Y-m-d H:i:s"),
            // 'updated_at' => date("Y-m-d H:i:s")
        ]);

        $todo->load('user');
        return $this->getResponseFactory()->giveSuccessResponse($todo);
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

            $todo = Todo::findOrFail($id);
            $payload = $request->only('body', 'is_complete');
            $todo->update($payload);

            return $this->getResponseFactory()->giveSuccessResponse($todo, Response::HTTP_OK, 'User successfully saved.');

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

            $todo = Todo::findOrFail($id);
            $snapshot = $todo;
            $todo->delete();

            //instead of we returning no content response to frontend.
            //we give old snapshot to frontend response for further usage.eg: used to display message.
            return $this->getResponseFactory()->giveSuccessResponse($snapshot, Response::HTTP_OK, 'User successfully removed.');

        } catch (ModelNotFoundException $e) {

            return $this->getResponseFactory()->giveErrorResponse('Resource not found.');
        }
    }
}
