<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display the list of users.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');
        $is_enabled = $request->get('is_enabled');
        $is_staff = $request->get('is_staff');

        $validator = Validator::make(
            [
                'name' => $name,
                'email' => $email,
                'password' => $password,
            ],
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:4'],
            ]
        );
        $validator->validate();

        $user = new User(
            [
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'is_enabled' => isset($is_enabled),
                'is_staff' => isset($is_staff),
            ]
        );
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User created!');
    }

    /**
     * Display the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * @todo Create a user details view
     */
    public function show($id)
    {
        return null;
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = User::find($id);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     *
     * @todo Add more password restrictions to make it secure
     */
    public function update(Request $request, $id)
    {
        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');
        $is_enabled = $request->get('is_enabled');
        $is_staff = $request->get('is_staff');

        $name_validator = Validator::make(['name' => $name], ['name' => ['required', 'string', 'max:255']]);
        $email_validator = Validator::make(
            ['email' => $email],
            ['email' => ['required', 'string', 'email', 'max:255', 'unique:users']]
        );
        $password_validator = Validator::make(
            ['password' => $password],
            ['password' => ['required', 'string', 'min:4']]
        );

        $name_validator->validate();

        $user = User::find($id);
        $user->name = $name;
        if ($user->email != $email) {
            $email_validator->validate();
            $user->email = $email;
        }
        if ($password) {
            $password_validator->validate();
            $user->password = Hash::make($password);
        }
        $user->is_enabled = isset($is_enabled);
        $user->is_staff = isset($is_staff);
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User updated!');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted!');
    }
}
