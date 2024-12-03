<?php

namespace App\Http\Controllers;

use App\Models\Lending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LendingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Lending::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $record = new Lending();
        $record->fill($request->all());
        $record->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $user_id, string $copy_id, $start)
    {
        $lending = Lending::where('user_id', $user_id)
            ->where('copy_id', $copy_id)
            ->where('start', $start)
            ->get();
        return $lending[0];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $user_id, $copy_id, $start)
    {
        $record = $this->show($user_id, $copy_id, $start);
        $record->fill($request->all());
        $record->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $user_id, $copy_id, $start)
    {
        $this->show($user_id, $copy_id, $start);
    }


    // egyéb lekérdezések

    public function lendingsWithCopies()
    {
        //$user = Auth::user();	//bejelentkezett felhasználó
        return  Lending::with('copies')->
            //where('user_id','=',$user->id)->
            get();
    }

    public function lendingsWithUsers()
    {
        //$user = Auth::user();	//bejelentkezett felhasználó
        return  Lending::with('usersDate')->where('start', '=', "2004-05-08")->get();
    }

    public function copySpecific($copy_id)
    {
        //$user = Auth::user();	//bejelentkezett felhasználó
        return  Lending::with('copies')->where('copy_id', '=', $copy_id)->get();
    }

    //hányszor kölcsönöztünk
    public function lendingCount()
    {
        $user = Auth::user();
        $lendings = DB::table('lendings as l')
            ->where('user_id', $user->id)
            ->count();

        return $lendings;
    }

    // hány aktív kölcsönzés van
    public function activeLendingCount()
    {
        $user = Auth::user();
        $lendings = DB::table('lendings as l')
            ->where('user_id', $user->id)
            ->whereNull('end')
            ->count();

        return $lendings;
    }

    public function lendingBooksCount()
    {
        $user = Auth::user();
        $books = DB::table('lendings as l')
            ->join('copies as c', 'l.copy_id', 'c.copy_id')
            ->where('user_id', $user->id)
            ->distinct('book_id')
            ->count();

        return $books;
    }

    public function lendingBooksData()
    {
        $user = Auth::user();
        $books = DB::table('lendings as l')
            ->join('copies as c', 'l.copy_id', 'c.copy_id')
            ->join('books as b', 'c.book_id', 'b.book_id')
            ->select('b.book_id', 'author', 'title')
            ->where('user_id', $user->id)
            ->groupBy('b.book_id')
            ->get();

        return $books;
    }

    public function lendingGroupMaxOne()
    {
        $user = Auth::user();
        $books = DB::table('lendings as l')
            ->join('copies as c', 'l.copy_id', 'c.copy_id')
            ->join('books as b', 'c.book_id', 'b.book_id')
            ->selectRaw('count(*) as ennyiszer, author, title')
            ->where('user_id', $user->id)
            ->groupBy('b.book_id')
            ->having('ennyiszer', '<', 2)
            ->get();

        return $books;
    }

    public function reservationsMoreThanXWeeks($weeks)
    { // Reservation::with(<fgv neve>)
        $weeks = $weeks * 7;
        $user = Auth::user();
        $reservation = DB::table('lending as l')
            ->join('copies as c', 'l.copy_id', '=', 'c.copy_id')
            ->join('books as b', 'l.book_id', '=', 'b.book_id')
            ->select('b.author', 'b.title')
            ->where('user_id', $user->id)
            ->whereNull('end')
            ->whereRaw("DATEIFF(CURRENT_DATE(), start) > $weeks")
            ->get();

        return $reservation;
    }

    public function bringBack($copy_id, $start)
    {
        //bejelentkezett felh
        $user = Auth::user();

        // melyik kölcsönzés
        $lending = $this->show($user->id, $copy_id, $start);

        //visszahozom a könyvet
        $lending->end = date(now());

        // mentés
        $lending->save();

        //2. esemény, szintént patch! ha több esemény
        // DB::table('copies')
        //     ->where('copy_id', $copy_id)
        //     //ebben benne van a mentés is!
        //     ->update(['status' => 0]);
        DB::select('CALL toLibrary(?)', array($copy_id));
    }
}
