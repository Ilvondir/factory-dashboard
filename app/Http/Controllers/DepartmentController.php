<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
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
        $departments = Department::orderBy("id")->with('positions')->get();
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
     * Store a newly created resource in storage.
     */
    public function store(DepartmentRequest $request)
    {
        Department::create($request->validated());
        return redirect()->route("departments.index");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentRequest $request, Department $department)
    {
        $department->update($request->validated());
        return redirect()->route("departments.index");
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
