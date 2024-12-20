<?php

namespace App\Http\Controllers;

use App\Models\copy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CopyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return copy::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $record = new copy();
        $record->fill($request->all());
        $record->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return copy::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $record = copy::find($id);
        $record->fill($request->all());
        $record->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        copy::find($id)->delete();
    }


    // Bizonyos évben kiadott példányok névvel és címmel kiíratása.
    public function booksWithYear($year) {
        $books = DB::table('copies as c')
        ->join('books as b', 'c.book_id', 'b.book_id')
        ->selectRaw('author, title')
        ->where('publication', $year)
        ->get();

        return $books;
    }
}
