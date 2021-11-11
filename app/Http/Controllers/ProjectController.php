<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Team;
use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth::user();
        $w = $user->id;
        //
        if ($user->type === 'coach') {
            // $coaches_team_id=auth::user()->teamscoached;
            // pluck do return arrays of given coloumn
            $coaches_team_id = DB::table('teams')
                ->where('user_id', $w)->pluck('id')->all();
            // return $coaches_team_id;
            $projects = Project::whereIn('team_id', $coaches_team_id)
                ->orderby('updated_at', 'desc')->paginate(5);
        } elseif ($user->type === 'product owner') {
            // as owned
            // $project=$user->myprojects;
            // $projects = Paginator::make($unit, count($project), 10);
            $projects = DB::table('projects')->where('user_id', $w)
                ->orderby('updated_at', 'desc')->paginate(5);
        } else {
            //  $projects=auth::user()->team->projects;
            $projects = DB::table('projects')->where('team_id', $user->team_id)
                ->orderby('updated_at', 'desc')->paginate(5);
        }
        return view('project.index')->with('data', $projects);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (auth()->user()->type !== 'coach') {
            return redirect('/home')->with('error', 'Unauthorized Page');
        }


        return view('project.create');
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
            $request,
            [
                'title' => "required",
                'owner_id' => "required",
                'team' => 'required',
            ]
        );

        // Create Post
        $project = new Project;
        $project->title = $request->input('title');
        $project->user_id = $request->input('owner_id');
        $project->team_id = $request->input('team');
        $project->save();

        $team = Team::find($request->input('team'));
        $team->project_id = $project->id;
        $team->save();

        return  redirect()->back()->with('success', 'Project Created Successfully!');
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


        $project = Project::find($id);

        $project->status = 'Finished';
        $project->save();
        $team = Team::find($project->team_id);
        $team->project_id = 1;
        $team->save();
        // return redirect()->back()->with('success',
        // 'Project updated Succefully!<br>Team {{$team->id}}
        // is ready to take another project');
        return  redirect()->back()
            ->with(
                'success',
                "Project updated Succefully!<br>Team $team->name"
                    . " with id $team->id is ready to take another project"
            );
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
