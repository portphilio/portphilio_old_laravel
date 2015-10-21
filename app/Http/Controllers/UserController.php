<?php

namespace Portphilio\Http\Controllers;

class UserController extends Controller
{
    /**
     * Displays a list of all users.
     *
     * @return View\Factory List view for users
     */
    public function getIndex()
    {
        return view('users.index', ['users' => User::all()]);
    }
}
