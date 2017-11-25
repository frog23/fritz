<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\Location;
use App\User;
use App\Category;

class GameController extends Controller
{
    public function index()
    {
        $points = session()->get('points');
        
        if ($points > 0) {
            return $this->play();
        }
        
        return view('game.welcome');
    }

    public function play()
    {
        $ticket = Ticket::where('edit_count', 0)->first();

        $points = session()->get('points', 0);

        return view('game.play', [
            'ticket' => $ticket,
            'locations' => Location::orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get(),
            'points' => $points
        ]);
    }

    public function addLocation()
    {
        return view('locations.create', ['redirect' => 'game.play']);
    }

    public function highscore()
    {
        $users = User::where('points', '>', 0)->orderBy('points', 'desc')->get();
        return view('game.highscore', ['users' => $users]);
    }
}
