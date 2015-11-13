<?php

namespace Portphilio\Http\Controllers;

use Portphilio\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index', ['users' => User::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($user = User::findBySlugOrId($id)) {
            return view('users.show', ['u' => $user]);
        }
    }

    public function profile()
    {
        $user = session('user');
        return view('users.show', ['u'=> $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // set up validation rules for different fields that may be passed in
        $messages = [
            'value.required' => 'This field cannot be blank.',
            'value.regex' => 'The username must be at least 3 alphanumeric characters long.',
            'value.unique' => 'The '.$request->input('name').' must be unique.',
            'value.email' => 'This must be a valid email address.',
            'value.mobile' => 'This must be a valid phone number.',
        ];
        $rules = [];
        switch ($request->input('name')) {
            case 'first_name':
            case 'last_name':
                $rules = ['value' => ['required']];
                break;
            case 'username':
                $rules = ['value' => ['required', 'unique:users,username', 'regex:/^[\w]{3,}$/']];
                break;
            case 'email':
                $rules = ['value' => ['required', 'email', 'unique:users,email']];
                break;
            case 'mobile':
                $rules = ['value' => ['regex:/^\(\d{3}\) \d{3}-\d{4}$/']];
            default:
                // unknown field
        }
        // validate
        $this->validate($request, $rules, $messages);
        // find the user
        if ($user = User::findBySlugOrId($id)) {
            // update and save the field being edited
            $user->{$request->input('name')} = $request->input('value');
            $user->save();
            // return a JSON representation of the updated user
            return $user->toJson();
        }

        return json_encode($request->input());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
