<?php

namespace App\Http\Controllers;

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
        $users = User::with(['role', 'logs'])->orderBy("role_id")->orderBy("id")->get();

        $canDeleteUsers = [];
        $canUpdateUsers = [];

        foreach ($users as $u) {
            $canUpdateUsers[] = \Auth::user()->can("update", $u);
            $canDeleteUsers[] = \Auth::user()->can("delete", $u);
        }

        return Inertia::render("users/Users", [
            "users" => $users->makeHidden('logs'),
            "canCreateUsers" => \Auth::user()->can("create", User::class),
            "canUpdateUsers" => $canUpdateUsers,
            "canDeleteUsers" => $canDeleteUsers
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
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
