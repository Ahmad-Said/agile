<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'about', 'references', 'showfile');
    }

    public function index()
    {
        return view('pages.index');
    }

    public function test()
    {
        return view('pages.test');
    }
    public function references()
    {
        return view('pages.references');
    }
    public function prof()
    {
        $a=Auth::user();
        return view('pages.profi')->with('a', $a);
    }

    public function about()
    {
        return view('pages.abou');
    }

    public function update(Request $request)
    {
        // return $request->all();
        $user=auth()->User();
        $user->name=$request->input("name");
        $user->email=$request->input("email");
        $user->save();

        return  redirect()->back()->withInput()->with('success', 'Profile Updated Successfully!');
    }

    public function showfile($file)
    {
        $filename = 'files\\'.$file;
        $path = storage_path($filename);
        return response()->file($path);
    }
}
