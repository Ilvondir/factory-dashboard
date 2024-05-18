<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::get();
        $positionsCounts = [];
        $canUpdateDepartments = [];
        $canDeleteDepartments = [];

        foreach ($departments as $d) {
            $positionsCounts[] = count($d->positions);
            $canUpdateDepartments[] = Auth::user()->can('update', $d);
            $canDeleteDepartments[] = Auth::user()->can('delete', $d);
        }

        return Inertia::render("departments/DepartmentsIndex", [
            "departments" => $departments,
            "positionsCounts" => $positionsCounts,
            "canUpdateDepartments" => $canUpdateDepartments,
            "canDeleteDepartments" => $canDeleteDepartments,
            "canCreateDepartments" => Auth::user()->can('create', Department::class)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @throws AuthorizationException
     */
    public function destroy(Department $department)
    {
        Gate::authorize("delete", $department);
        Department::destroy($department->id);

        return redirect()->route("departments.index");
    }
}
