<?php

namespace App\Http\Controllers;

use App\Http\Requests\PositionRequest;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $positions = Position::with(["department", "workers"])->paginate(100);

        $canUpdatePositions = [];
        $canDeletePositions = [];

        foreach ($positions as $p) {
            $canUpdatePositions[] = Auth::user()->can('update', $p);
            $canDeletePositions[] = Auth::user()->can('delete', $p);
        }

        return Inertia::render("positions/Positions", [
            "positions" => $positions,
            "canCreatePositions" => Auth::user()->can('create', Position::class),
            "canUpdatePositions" => $canUpdatePositions,
            "canDeletePositions" => $canDeletePositions,
            "departments" => Department::get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PositionRequest $request)
    {
        \Gate::authorize("create", Position::class);

        $data = $request->validated();

        Department::find($data["department"])->positions()->create([
            "name" => $data["name"],
            "responsibilities" => $data["responsibilities"]
        ]);

        return redirect()->route("positions.index");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Position $position)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @throws AuthorizationException
     */
    public function destroy(Position $position)
    {
        \Gate::authorize('delete', $position);
        Position::destroy($position->id);
        return redirect()->route("positions.index");
    }
}
