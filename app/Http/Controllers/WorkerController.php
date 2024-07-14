<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Worker;
use App\Http\Requests\WorkerRequest;
use App\Http\Requests\UpdateWorkerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;
use League\Csv\CannotInsertRecord;
use League\Csv\Exception;
use League\Csv\Writer;

class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchQuery = $request->input("query");

        $workers = Worker::with("position.department")
            ->orWhere("first_name", "LIKE", "%{$searchQuery}%")
            ->orWhere("last_name", "LIKE", "%{$searchQuery}%")
            ->orWhere("email", "LIKE", "%{$searchQuery}%")
            ->orderBy("id")
            ->paginate(10);

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
            "canDeleteWorkers" => $canDeleteWorkers,
            "departments" => Department::with("positions")->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WorkerRequest $request)
    {
        Gate::authorize("create", Worker::class);

        Worker::create($request->validated());

        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WorkerRequest $request, Worker $worker)
    {
        Gate::authorize("update", $worker);

        Worker::findOrFail($worker->id)->update($request->validated());

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Worker $worker)
    {
        Gate::authorize("delete", $worker);

        Worker::destroy($worker->id);

        return back();
    }

    /**
     * @throws CannotInsertRecord
     * @throws Exception
     */
    public function downloadCSV()
    {
        $workers = Worker::with("position.department")->get();

        $header = ["id", "first_name", "last_name", "position", "salary", "phone_number", "email", "address", "department"];
        $csv = Writer::createFromString("")->setDelimiter(";");
        $csv->insertOne($header);

        foreach ($workers as $w) {
            $csv->insertOne([
                $w->id,
                $w->first_name,
                $w->last_name,
                $w->position->name,
                $w->salary,
                $w->phone_number,
                $w->email,
                $w->address,
                $w->position->department->name
            ]);
        }

        $csv->setDelimiter(";");

        date_default_timezone_set("Europe/Warsaw");
        $filename = "workers" . date('YmdHis') . ".csv";

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
