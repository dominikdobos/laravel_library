<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{

    // könyvtáros + admin
    public function index()
    {
        return Reservation::all();
    }

    /**
     * könyvtáros
     */
    public function store(Request $request)
    {
        $record = new Reservation();
        $record->fill($request->all());
        $record->save();
    }

    /**
     * 
     */
    public function show(string $user_id,$book_id,$start)
    {
        $reservation = Reservation::where('user_id', $user_id)
        ->where('book_id',$book_id)
        ->where('start',$start)
        ->get();
        return $reservation[0];
    }

    /**
     * könyvtáros
     */
    public function update(Request $request, string $user_id,$book_id,$start)
    {
        $record = $this->show($user_id,$book_id,$start);
        $record->fill($request->all());
        $record->save(); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $user_id, $book_id, $start)
    {
        Reservation::show($user_id, $book_id, $start)->delete();
    }


    // saját lekérdezés

    public function reservedBooks() { // Reservation::with(<fgv neve>)
        $user = Auth::user();
        return Reservation::with('books')
        ->where('user_id', $user->id) // default: ('user_id', '=', $user->id)  
        ->get();
    }

    public function reservationsWithUsers() { // Reservation::with(<fgv neve>)
        $user = Auth::user();
        return Reservation::with('users')
        ->where('user_id', $user->id) // default: ('user_id', '=', $user->id)  
        ->get();
    }

    public function reservationCount() { // Reservation::with(<fgv neve>)
        $user = Auth::user();
        return Reservation::with('users2')
        ->where('user_id', $user->id) // default: ('user_id', '=', $user->id)  
        ->count();
    }

    
}
