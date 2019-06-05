<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use App\User;
class TeamController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        // Check for correct user
        if(auth()->user()->type !=='coach') {
            return redirect('/home')->with('error', 'Unauthorized Page');
        }
        return view('team.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate(
            $request, [
            'members' => ["required","array","min:2"],
            'name' => 'required',
            'location'=>'required',
            ]
        );
        if(User::find($request->input('members')[0])->type!=='scrum-master') {
             return redirect()->back()->withInput()->with('error', 'Scrum Master Not Precised! Register a new one.');
        }
        //    'cover_image' => 'image|nullable|max:1999'
        // Handle File Upload
        // if($request->hasFile('cover_image')){
        //     // Get filename with the extension
        //     $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
        //     // Get just filename
        //     $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        //     // Get just ext
        //     $extension = $request->file('cover_image')->getClientOriginalExtension();
        //     // Filename to store
        //     $fileNameToStore= $filename.'_'.time().'.'.$extension;
        //     // Upload Image
        //     $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        // } else {
        //     $fileNameToStore = 'noimage.jpg';
        // }

        // Create Post
        $team = new Team;
        $team->name = $request->input('name');
        $team->location = $request->input('location');
        $team->user_id = auth()->user()->id;
        // $post->cover_image = $fileNameToStore;
        $team->save();
        foreach($request->input('members') as $userid)
        {
            $user = User::find($userid);

            $user->team_id = $team->id;

            $user->save();
        }    
        return redirect('/home')->with('success', 'Team Created Succefully!');
        // return $request->input('members');
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
        $team=Team::find($id);
        return views('team.show')->with('team', $team);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
