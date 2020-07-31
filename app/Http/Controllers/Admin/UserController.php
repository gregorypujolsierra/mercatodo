<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display the list of users.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $roles = Role::all();

        return view('admin.users.create', compact(['roles']));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');
        $is_enabled = $request->get('is_enabled');
        $role = $request->get('roles') ?? 3;

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
                'role_id' => (int)$role,
            ]
        );
        $user->save();

        return redirect()->route('admin.users.index')->with($type = 'success', 'User created!');
    }

    /**
     * Display the specified user.
     *
     * @param int $id
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
     * @param int $id
     * @return Application|RedirectResponse|Factory|View
     *
     * @todo Redirect to 404 if $id doesn't exists in db
     */
    public function edit(int $id)
    {
        if (Gate::denies('manage-users')) {
            return redirect(route('admin.users.index'))
                ->with($type = 'error', 'You do not have permission for this action');
        }

        $user = User::find($id);
        $roles = Role::all();

        return view('admin.users.edit', compact(['user', 'roles']));
    }

    /**
     * Update the specified user in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Application|RedirectResponse|Redirector
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
        $is_enabled = $request->get('is_enabled');
        $role = $request->get('roles') ?? 3;

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
        $user->role_id = (int)$role;

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User updated!');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(int $id)
    {
        if (Gate::denies('manage-users')) {
            return redirect(route('admin.users.index'))
                ->with($type = 'error', 'You do not have permission for this action');
        }

        $user = User::find($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted!');
    }
}
