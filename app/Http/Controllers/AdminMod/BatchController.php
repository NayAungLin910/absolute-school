<?php

namespace App\Http\Controllers\AdminMod;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $startdate = null;
        $enddate = null;

        $batches = Batch::latest()->withCount('student', 'subject')->paginate(10);
        return view('admin-mod.batch.index-batch', compact('batches', 'startdate', 'enddate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin-mod.batch.create-batch');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|unique:batches,name",
        ]);

        $batch = Batch::create([
            "name" => $request->name,
        ]);

        if ($batch) {
            return redirect()->back()->with("success", $batch->name . " is has been created!");
        } else {
            return redirect()->back()->with("error", "Something went wrong!");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $batch = Batch::where('id', $id)->first();
        if ($batch) {
            return view('admin-mod.batch.update-batch', compact('batch'));
        } else {
            return redirect()->back()->with("error", "Batch not found!");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => "required|unique:batches,name,$id",
        ]);

        $batch = Batch::where('id', $id)->first();
        if ($batch) {
            $batch->name = $request->name;
            $batch->save();
            return redirect()->back()->with("success", "The new name " . $request->name . " has been saved!");
        } else {
            return redirect()->back()->with("error", "Batch not found!");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $batch = Batch::where('id', $id)->first();
        if ($batch) {
            $b_name = $batch->name;
            $batch->delete();
            return redirect()->route('batch.index')->with("success", "$b_name has been deleted!");
        } else {
            return redirect()->route('batch.index')->with("error", "Batch not found!");
        }
    }

    public function searchBatch(Request $request)
    {
        $request->validate([
            "search" => "required",
        ]);

        $batches = Batch::orderBy('id', 'DESC');

        if ($request->search) {
            $batches = $batches->where("name", "like", "%$request->search%");
        }

        $startdate = null;
        $enddate = null;

        if ($request->startdate && $request->enddate) {
            $batches =  $batches->whereBetween('created_at', [$request->startdate . " 00:00:00", $request->enddate . " 23:59:59"]);
            $startdate = $request->startdate;
            $enddate = $request->enddate;
        }

        $batches =  $batches->paginate(10);
        return view('admin-mod.batch.index-batch', compact('batches', 'startdate', 'enddate'));
    }
}
