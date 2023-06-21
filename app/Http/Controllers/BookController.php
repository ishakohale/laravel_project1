<?php

namespace App\Http\Controllers;

use App\Models\Book;


use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $data = Book::where('price','<',1000)->get()->count();
        // dd($data);

        if ($request->ajax()) {
            // dd($request->ajax());


            $data = Book::all();

            return DataTables::of($data)
                ->addColumn('action', function ($row) {

                    return "<button class='btn btn-info edit' data-id='" . $row->id . "'> Edit </button> <button class='btn btn-danger delete' data-id='" . $row->id . "'> Delete </button>";
                })
                ->make(true);
        }
    return view('books.index');

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
        $book            = new Book;
        $book->bookname  = $request->bookname;
        $book->auther    = $request->auther;
        $book->price     = $request->price;
        $book->save();
        return response()->json(array('success' => true, 'message' => 'Book Added successfully'));
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
    public function edit( $id)
    {
        $data = Book::find($id);
        $returnHTML =  view('books.edit', compact('data'))->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // dd($request->book,$request->all());
        $data = Book::find($request->id);
        $data->bookname    = $request->bookname;
        $data->auther    = $request->auther;
        $data->price  = $request->price;
        $data->save();

        return response()->json(array('success' => true, 'message' => 'Student Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $data = Book::find($request->id);
        $data->delete();
        return response()->json(array('success' => true, 'message' => 'Student Deleted successfully'));
    }
}
