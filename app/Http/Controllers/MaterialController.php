<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaterialChangeAmountRequest;
use App\Http\Requests\MaterialStoreRequest;
use App\Http\Requests\MaterialUpdateRequest;
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
        $materials = Material::orderBy("id")->paginate(10);

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
    public function store(MaterialStoreRequest $request)
    {
        Gate::authorize("create", Material::class);

        date_default_timezone_set("Europe/Warsaw");
        $material = Material::create($request->validated());

        $material->log("Material " . $material->name . " created.", 1);

        return back();
    }

    public function update(MaterialUpdateRequest $request, Material $material)
    {
        Gate::authorize("update", $material);

        $material->update($request->validated());
        $material->log("Material " . $material->name . " updated.", 2);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        Gate::authorize("delete", $material);

        $material->log("Material " . $material->name . " deleted.", 3);
        Material::destroy($material->id);

        return back();
    }

    public function addAmount(MaterialChangeAmountRequest $request, Material $material)
    {
        Gate::authorize("changeAmount", $material);

        $value = $request->validated()["value"];

        $material->amount += $value;
        $material->save();

        $material->log("Added " . $value . " items of " . $material->name . " to the warehouse.", 4);

        return back();
    }

    public function removeAmount(MaterialChangeAmountRequest $request, Material $material)
    {
        Gate::authorize("changeAmount", $material);

        $value = $request->validated()["value"];

        $material->amount -= $value;
        $material->save();

        $material->log("Removed " . $value . " items of " . $material->name . " from the warehouse.", 4);

        return back();
    }
}
