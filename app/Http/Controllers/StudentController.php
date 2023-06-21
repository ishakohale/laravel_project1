<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Yajra\DataTables\DataTables;


class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // dd("ajaxcall");

            $data = Student::all();

            return DataTables::of($data)
                ->addColumn('action', function ($row) {

                    return "<button class='btn btn-info edit' data-id='" . $row->id . "'> Edit </button> <button class='btn btn-danger delete' data-id='" . $row->id . "'> Delete </button>";
                })
                ->make(true);
        }
//  dd("return");
     return view('students.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd("store");
        $student            = new Student;
        $student->name  = $request->name;
        $student->city    = $request->city;
        $student->contact     = $request->contact;
        $student->save();
        return response()->json(array('success' => true, 'message' => 'Student Added successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Student::find($id);
        // dd("render",$data,$id);
        $returnHTML =  view('students.edit', compact('data'))->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data = Student::find($request->id);
        $data->name     = $request->name;
        $data->city     = $request->city;
        $data->contact  = $request->contact;
        $data->save();

        return response()->json(array('success' => true, 'message' => 'Student Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {

        $data = Student::find($request->id);
        $data->delete();
        return response()->json(array('success' => true, 'message' => 'Student Deleted successfully'));
    }

}
