<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with(['role'])->orderBy("role_id")->orderBy("id")->paginate(10);

        $canDeleteUsers = [];
        $canUpdateUsers = [];

        foreach ($users as $u) {
            $canUpdateUsers[] = \Auth::user()->can("update", $u);
            $canDeleteUsers[] = \Auth::user()->can("delete", $u);
        }

        return Inertia::render("users/Users", [
            "users" => $users,
            "canCreateUsers" => \Auth::user()->can("create", User::class),
            "canUpdateUsers" => $canUpdateUsers,
            "canDeleteUsers" => $canDeleteUsers,
            "roles" => Role::orderBy("id")->get()
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreateRequest $request)
    {
        \Gate::authorize('create', User::class);

        User::create($request->validated() + ['password' => \Hash::make('password')]);

        return back();
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        \Gate::authorize('update', $user);

        $user->update($request->validated());

        return back();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        \Gate::authorize("delete", $user);
        User::destroy($user->id);
        return back();
    }
}
