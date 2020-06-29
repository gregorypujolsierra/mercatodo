<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
        $roles = Role::all();

        return view('admin.users.create', compact(['roles']));
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
            ]
        );
        $user->save();
        $user->roles()->sync($request->roles);

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
    public function show(int $id)
    {
        return null;
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @todo Redirect to 404 if $id doesn't exists in db
     */
    public function edit(int $id)
    {
        if (Gate::denies('manage-users')) {
            return redirect(route('admin.users.index'));
        }

        $user = User::find($id);
        $roles = Role::all();

        return view('admin.users.edit', compact(['user', 'roles']));
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
    public function update(Request $request, int $id)
    {
        if (Gate::denies('manage-users')) {
            return redirect(route('admin.users.index'));
        }

        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');

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
        $user->save();
        $user->roles()->sync($request->roles);

        return redirect()->route('admin.users.index')->with('success', 'User updated!');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(int $id)
    {
        if (Gate::denies('manage-users')) {
            return redirect(route('admin.users.index'));
        }

        $user = User::find($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted!');
    }
}
