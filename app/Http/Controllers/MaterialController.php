<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
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
            "canDeleteMaterials" => $canDeleteMaterials
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
        //
    }
}
