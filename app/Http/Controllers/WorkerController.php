<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use App\Http\Requests\StoreWorkerRequest;
use App\Http\Requests\UpdateWorkerRequest;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workers = Worker::with("position.department")->get();

        $canEditWorkers = [];
        $canDeleteWorkers = [];

        foreach ($workers as $w) {
            $canEditWorkers[] = \Auth::user()->can("update", $w);
            $canDeleteWorkers[] = \Auth::user()->can("delete", $w);
        }


        return Inertia::render("workers/Workers", [
            "workers" => $workers,
            "canCreateWorkers" => \Auth::user()->can("create", Worker::class),
            "canEditWorkers" => $canEditWorkers,
            "canDeleteWorkers" => $canDeleteWorkers
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
    public function store(StoreWorkerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Worker $worker)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Worker $worker)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorkerRequest $request, Worker $worker)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Worker $worker)
    {
        //
    }
}
