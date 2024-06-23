<?php

namespace App\Http\Controllers;

use App\Http\Requests\SessionsDestroyOtherRequest;
use App\Http\Requests\UserChangePasswordRequest;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function show()
    {
        $sessions = Auth::user()->sessions()->orderBy('last_activity', 'desc')->get();
        $canDeleteSessions = [];

        foreach ($sessions as $s) {
            $canDeleteSessions[] = Auth::user()->can('destroySession', $s);
        }

        return Inertia::render("profile/Profile", [
            "sessions" => $sessions,
            "canDeleteSessions" => $canDeleteSessions,
            "actionsNumber" => Auth::user()->logs->count()
        ]);
    }

    public function destroySession(Request $request, Session $session)
    {
        \Gate::authorize('destroySession', $session);
        Session::destroy($session->id);

        return back();
    }

    public function destroyOther(SessionsDestroyOtherRequest $request)
    {
        $ids = $request->validated();

        foreach ($ids as $id) {
            \Gate::authorize('destroySession', Session::whereId($id)->first());
            Session::destroy($id);
        }

        return back();
    }

    public function changePassword(UserChangePasswordRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();
        if (\Hash::check($data['old_password'], $user->password)) {

            $user->password = \Hash::make($data['password']);
            $user->save();
            
            return back();

        } else return back()->withErrors(['old_password' => "Old password is incorrect."]);
    }
}
