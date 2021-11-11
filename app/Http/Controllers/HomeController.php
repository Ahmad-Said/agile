<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        if ($user->type == 'admin') {
            $users = User::orderby('id')->paginate(5);
            return view('home')->with('allusers', $users);
        } else {
            if ($user->type === 'coach') {
                // we can query databases and paginate them ...
                $teams = $user->teamscoached;
                return view('home')->with('teams', $teams);
            } elseif ($user->type === 'product owner') {
                return redirect('/project');
            } else {
                $team = User::orderby('id')
                    ->where('team_id', $user->team_id)->paginate(5);
                return view('home')->with('team', $team);
            }
        }
        return view('home');
    }
}
