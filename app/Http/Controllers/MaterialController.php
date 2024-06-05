<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaterialRequest;
use App\Models\Material;
use Composer\Pcre\MatchResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materials = Material::orderBy("id")->get();

        $canUpdateMaterials = [];
        $canDeleteMaterials = [];

        foreach ($materials as $m) {
            $canUpdateMaterials[] = \Auth::user()->can("update", $m);
            $canDeleteMaterials[] = \Auth::user()->can("delete", $m);
        }


        return Inertia::render("materials/Materials", [
            "materials" => $materials,
            "canCreateMaterials" => \Auth::user()->can("create", Material::class),
            "canUpdateMaterials" => $canUpdateMaterials,
            "canDeleteMaterials" => $canDeleteMaterials,
            "canChangeAmount" => \Auth::user()->can("changeAmount", $materials[0])
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(MaterialRequest $request)
    {
        Gate::authorize("create", Material::class);

        date_default_timezone_set("Europe/Warsaw");
        Material::create($request->validated() + ["added" => date("Y/m/d")]);

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Material $material)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        Gate::authorize("delete", $material);

        Material::destroy($material->id);

        return back();
    }
}
