<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use App\Models\Student;
use App\Models\Book;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


class LabController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // dd("ajaxcall");

            $data = Lab::all();


            return DataTables::of($data)
                ->addColumn('student_id', function ($row) {
                    // dd($row->student_id,Student::find($row->student_id)->name);
                    $name=Student::find($row->student_id)->name;
                        return $name;

                })
                ->addColumn('book_id', function ($row) {
                    // dd($row->student_id,Student::find($row->student_id)->name);

                        $name= Book::find($row->book_id)->bookname;
                        return $name;

                })
                ->addColumn('action', function ($row) {

                    return "<button class='btn btn-danger delete' data-id='" . $row->id . "'>return</button>";
                })
                ->make(true);
        }
//  dd("return");

$student = Student::all();
$book = Book::all();
// dd("gsd",$student,$book);
     return view('index',compact('student','book'));
    }

    /**return view('welcome', compact('array1', 'array2', 'array3');

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
        // dd($request->all());
        $student            = new Lab   ;
        $student->student_id  = $request->student;
        $student->book_id    = $request->bookname;
        $student->Date     = $request->date;
        $student->save();
        return response()->json(array('success' => true, 'message' => 'Student Added successfully'));
    }
//
    /**
     * Display the specified resource.
     */
    public function show(Lab $lab)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lab $lab)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lab $lab)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {

        $data = Lab::find($request->id);
        $data->delete();
        return response()->json(array('success' => true, 'message' => 'Student Deleted successfully'));
    }
}
