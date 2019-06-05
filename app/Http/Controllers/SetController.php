<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Set;
use Auth;
use App\User;
use Session;
use DB;
use App\Team;
use App\Question;
use pChart\{
    pColor,
    pDraw,
    pRadar
};

// testting temp can be removed
use App\Project;

class SetController extends Controller
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
        //
        $type=auth::user()->type;
        if($type=='admin') {
            return view('/home')->with('error', 'You cannot see set');
        }

        if($type=='coach') {      
              $a=auth::user()->mysets;
        } else
            {
                $a=auth::user()->sets_answered;  // those set are sent by coach by pivot table
        }
        return view('set.index')->with('mysets', $a);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(auth()->user()->type !=='coach') {
            return redirect('/home')->with('error', 'Unauthorized Page');
        }
        return view('set.create');
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
            'title' =>"required",
            ]
        );

        // Create Post
        $item = new Set;
        $item->title = $request->input('title');
        $item->user_id=auth::user()->id;
        $item->save();

        return  redirect("set/$item->id")->with('success', 'Set Created Successfully!');
        
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
        $a=Set::find($id);
        // $ques=$a->myquestions;
        return view('set.show')->with('set', $a);
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
        // check authentication
        $set=Set::find($id);
        $set->delete();
        return redirect()->back()->with('success', "Set Deleted Successfully!<br><small>Note: This will reset all user data and submitted form");
    }


    public function showform($id)
    {
        
        if(auth::user()->type==='admin'  ) {
            return redirect('/set')->with('error', 'you are admin !!');
        }


        // check if the user has sended this set to fill
        $user = auth::user();
        // $sets=$user->sets_answered;
        $set_id=$id;
        // $setform=App\Set::find($set_id);
        $exists = $user->sets_answered->contains($set_id);
        if(!$exists) {
             return redirect('/home')->with('error', 'You have no such set to fill');
        } 
        // redirect to fill form by user 
        $set=Set::find($id);
        return view('set.showform')->with('set', $set);
    }
    public function storeanswer(Request $request )
    {
        // here store the final post page in the database
        
        
        
        //attach is used to add a new record regardless of older relation ship 
        // that mean it may duplicate so we can detach relation ship and attach a new one
        // or we just use update exsiting
        // note when coach want to add he will iterate on user and apply this function:
        // $user->sets_answered()->attach($set_id, ['answer' => implode(';',$request['response'])]);
        // check https://laravel.com/docs/5.0/eloquent#working-with-pivot-tables for references 
        // $user->sets_answered()->updateExistingPivot($set_id, ['answer' => implode(';',$request['response'])]);
        
        
        // the new way:
        $set_id=$request->input('set_id');
        $set=Set::find($set_id);
        $user=auth::user();
        // return $request->all();
        // $questions=Question::orderby('id')->where('set_id',$set_id)->get();
        //................................additional data to pivot table
        //$user->roles()->attach($roleId, ['expires' => $expires]);
        // return $user;

        
      

        // old way to do but now if we add a new question status got pending wihout attaching the new question 
        // so will iterate on $set first and detach and attach relations 

        //  check on how https://stackoverflow.com/questions/24555697/check-if-belongstomany-relation-exists-laravel
        // foreach($set->myquestions as $quest)
        // {
        //     if(!$user->questions_asked->contains($quest->id))
        //         $user->questions_asked()->attach($quest->id);
        // }

        // update answer questions:
        // $questions=$user->questions_asked()->where('set_id',$set_id)->pluck('question_id');
        $questions=$user->questions_asked;
        $i=0;
        //   return count($questions);
        // return $questions;
        // return $request->all();
        // return $questions;
        foreach($questions as $quest){

            $user->questions_asked()->updateExistingPivot($quest->id, ['answer' => $request['response'][$i]]);
            $i++;
        }

        // update status of set to done
        $user->sets_answered()->updateExistingPivot($set_id, ['status' => 'done']);
        return redirect('/set')->with('success', 'Thanks to you!<br><small>Form Data submitted successfully</small>');
    }

    private function Attach_User_to_set(User $user,Set $set)
    {
        $set_id=$set->id;
        $exists = $user->sets_answered->contains($set_id);
        if(!$exists) {
                $user->sets_answered()->attach($set_id);
            foreach($set->myquestions as $quest)
                {
                $user->questions_asked()->attach($quest->id);
            }
        }
        else {
                Session::flash('warning', 'Send occur with some redandant due to already sent form ');
        } 
        return $user;
    }
    public function SendForm(Request $request )
    {
        $this->validate(
            $request, [
            'set_id' => 'required',
            ]
        );
        $set_id=$request->input('set_id');
        // return $request->all();
        $set=Set::find($set_id);
        if(count($set->myquestions)==0) {
            return redirect('/home')->with('error', 'The Selected Set is empty!');
        }
        $submit=$request->input('sub');
        $cid=auth::user()->id; 
        
        $query="select * from users where parentid= $cid and type=? and team_id!=1";

        if($submit=='Send Set to all Scrum Masters') {
           
            $a=DB::select($query, ["scrum-master"]);
        }else
        {
            if($submit=="Send Set to all developpers") {
                $a=DB::select($query, ["developer"]);
            }
        }
        if($submit!=null) {
            foreach($a as $usere)
            {
                // check if set is already sent
                $user=User::find($usere->id);
                $this->Attach_User_to_set($user, $set);
            }
            return redirect('/home')->with('success', 'Set Form Send Successfully!');
        }
        // return $request->all();
       
       
          
        $members=$request->input('members');
        $teams=$request->input('teams');
           
            // $setform=App\Set::find($set_id);
        if($members==null && $teams==null) {
            return redirect('/home')->with('error', 'Select at least one Checkbox option!');
        }
        if($members!=null) {

      
            foreach($members as $id)
            {
                $user=User::find($id);
                $this->Attach_User_to_set($user, $set);
            }
        }
        if($teams!=null) {
            
            foreach($teams as $team)
            {
                $teamf=Team::find($team);
                foreach($teamf->members as $user)
                {
                    $this->Attach_User_to_set($user, $set);
                }
                if($teamf->project_id!=1) {
                    $this->Attach_User_to_set(Project::find($teamf->project_id)->owner, $set);
                }
            }
        
        }
        return redirect('/home')->with('success', 'Set Form Send Successfully!');
        
    }

    public function showanalysis($id)
    {
        // return Set::find($id)->users_answered;
        // just testing relation ship nothing to do with function
        // return User::find(Project::find(2)->user_id);
        // return Project::find(2)->owner;
        // return User::find(5)->myprojects;
        // return Set::find($id)->users_answered()->orderby('team_id')->get()->pluck('team_id');
        // return User::find(3)->sets_answered()->get()->pluck('pivot')->where('set_id',1)->pluck('status');
        // return Team::find(2)->hasAnswer(1);
        if(auth::user()->type=='coach') {
            $set=Set::find($id);
            // return $set->users_answered->pluck('pivot')->pluck('answer');
            // $query="select * from set_user where set_id=?";
            // $a=DB::select($query,[$id]);

            if(count($set->myquestions)==0) {
                return redirect()->back()->with('error', "No question in set<br><small><a href='/set/$id'>Add now</a></small>");
            }

            $a=$set->users_answered;
            if(count($a)==0) {
                return redirect('/set')->with('error', 'You have not Send Set to Anyone<br><small><a href=/home>Send now</a></small>')->with('set_id', $id);
            }
            
            $exist=0;
            foreach( $set->users_answered->pluck('pivot')->pluck('status') as $status)
            {
                if($status=='done') {
                    $exist=1;
                }
            }
            if(!$exist) {
                 return redirect()->back()->with('error', 'No one Answered Your Form Set');
            }
        
             $request=new Request;
            $request['set_id']=$id;
            $set=Set::find($id);
            // here fill the correct parameter

            // chart calculation :
            // by default the first groupe is scrum master 
            // and the second groupe is all the way selected
            // $dataA=array();
            // $dataB=array();

            $raw="";
            foreach($set->users_answered as $user){
                if($user->pivot->status=='done') {
                    $raw.=',A'.$user->id;
                    if($user->type=='scrum-master') {
                        $raw.=',B'.$user->id;
                    }
                }
            }
            
            if (strpos($raw, 'B') !== true) {
                // make A as B
                $rawb= $raw;
                $rawb=str_replace('A', 'B', $raw);
                $raw.=$rawb;
            }
            $request['raw']=$raw;
            return $this->calculateanalysis($request, $id);
        }
        return view('/home')->with('error', "Unauthorized Page");
    }
    public function calculateanalysis(Request $request)
    {
        // return $request->all();
        // i dont think i used this one before it should 
        // now be used to take members to include in each chart 
        // and type of the chart
        $this->validate(
            $request, [
            'raw' =>"required",
            'set_id'=>"required"
            ]
        ); // G mean group
       
        //  $GAID=$request->input('GAID');
        //  $GBID=$request->input('GBID');
         $set_id=$request->input('set_id');
         $raw=$request->input('raw');
         $set=Set::find($set_id);
        //    explode raw data:
        $before_id=explode(',', $raw); 
        $GAID=array();
        $GBID=array();
        // return $before_id;
        foreach($before_id as $raw_id)
        {
            if($raw_id==null||$raw_id=="") {
                continue;
            }
            // return $raw_id[1];
            // return substr($raw_id,1);
            $sub=substr($raw_id, 1);
            if(is_numeric($sub)) {
                $id= intval($sub);
                if($raw_id[0]=='A') {
                    $GAID[]=$id;
                } else {
                    $GBID[]=$id;
                }
            
            }
        }   
        if(count($GAID)==0 || count($GBID)==0) {
            return $this->showanalysis($set_id)->with('error', 'You must select one checkbox at least in each groupe!');
        }

        // generating $dataA contain the average of group A on each question
       
        $n=0;
        foreach($set->myquestions as $quest)
        {
            $dataA[]=0;
            $dataB[]=0;
            $questions[]=$quest->label;
            $n++;//or jusst use count idk..
        }
        foreach($GAID as $user_id)
        {
            $user=User::find($user_id);
            $i=0;
            foreach($user->question_set_asked($set_id) as $quest){
                $dataA[$i]+=$quest->pivot->answer;
                $i++;
            }
           
        }
        foreach($GBID as $user_id)
        {
            $user=User::find($user_id);
            $i=0;
            foreach($user->question_set_asked($set_id) as $quest){
                $dataB[$i]+=$quest->pivot->answer; 
                $i++;
            }
          
        }
        $i=0;
        foreach($user->question_set_asked($set_id) as $quest){
             $dataA[$i]/=count($GAID);
             $dataB[$i]/=count($GBID);
             $i++;
        }
        //    return $dataA;
        $this->generate_graph($dataA, $dataB, $questions);
        //    return $data;
        // check test pages for a smaller template
        return view('set.analysis')->with('set', $set);
    }

    private function generate_graph($dataA,$dataB,$questions)
    {  
        // where data are the answer calculated by average 
        // ans $quest will be showen on graph
        // all arrays have the same size
        
        $myPicture = new pDraw(700, 230);

            /* Populate the pData object */
            $myPicture->myData->addPoints($dataA, "ScoreA");  
            $myPicture->myData->addPoints($dataB, "ScoreB"); 
            $myPicture->myData->setSerieDescription("ScoreA", "Group A");
            $myPicture->myData->setSerieDescription("ScoreB", "Group B");

            /* Define the abscissa serie */
        
            $myPicture->myData->addPoints($questions, "Labels");
            $myPicture->myData->setAbscissa("Labels");

            /* Draw a solid background */
            $myPicture->drawFilledRectangle(0, 0, 700, 230, ["Color"=>new pColor(179, 217, 91), "Dash"=>true, "DashColor"=>new pColor(199, 237, 111)]);

            /* Overlay some gradient areas */
            $Settings = 
            $myPicture->drawGradientArea(0, 0, 700, 230, DIRECTION_VERTICAL, ["StartColor"=>new pColor(194, 231, 44, 50),"EndColor"=>new pColor(43, 107, 58, 50)]);
            $myPicture->drawGradientArea(0, 0, 700, 20, DIRECTION_VERTICAL, ["StartColor"=>new pColor(0, 0, 0, 100),"EndColor"=>new pColor(50, 50, 50, 100)]);

            /* Add a border to the picture */
            $myPicture->drawRectangle(0, 0, 699, 229, ["Color"=>new pColor(0, 0, 0)]);

            /* Write the picture title */ 
            $fontpath=base_path()."/vendor/bozhinov/pchart/pChart/fonts/";
            $myPicture->setFontProperties(array("FontName"=>$fontpath."Silkscreen.ttf","FontSize"=>6));
            $myPicture->drawText(10, 13, "pRadar - Draw radar charts", ["Color"=>new pColor(255, 255, 255)]);

            /* Set the default font properties */ 
            $myPicture->setFontProperties(array("FontName"=>$fontpath."Forgotte.ttf","FontSize"=>10,"Color"=>new pColor(80, 80, 80)));

            /* Enable shadow computing */ 
            $myPicture->setShadow(true, ["X"=>1,"Y"=>1,"Color"=>new pColor(0, 0, 0, 10)]);

            /* Create the pRadar object */ 
            $SplitChart = new pRadar($myPicture);

            /* Draw a radar chart */ 
            $myPicture->setGraphArea(10, 25, 300, 225);
            $Options = [
                "Layout"=>RADAR_LAYOUT_STAR,
                "BackgroundGradient"=>["StartColor"=>new pColor(255, 255, 255, 100),"EndColor"=>new pColor(207, 227, 125, 50)],
                "FontName"=>$fontpath."pf_arma_five.ttf","FontSize"=>6
                // ,    "WriteValues"=>TRUE  // add this line to show value points on chart
            ];
            $SplitChart->drawRadar($Options);

            /* Draw a radar chart */ 
            $myPicture->setGraphArea(390, 25, 690, 225);
            $Options = [
                "Layout"=>RADAR_LAYOUT_CIRCLE,
                "LabelPos"=>RADAR_LABELS_HORIZONTAL,
                "BackgroundGradient"=>["StartColor"=>new pColor(255, 255, 255, 50),"EndColor"=>new pColor(32, 109, 174, 30)],
                "FontName"=>$fontpath."pf_arma_five.ttf","FontSize"=>6
            ];
            $SplitChart->drawRadar($Options);

            /* Write the chart legend */ 
            $myPicture->setFontProperties(["FontName"=>$fontpath."pf_arma_five.ttf","FontSize"=>6]);
            $myPicture->drawLegend(235, 205, ["Style"=>LEGEND_BOX,"Mode"=>LEGEND_HORIZONTAL]);

            /* Render the picture (choose the best way) */
            $myPicture->render("storage/graph_images/final_result.png");
    }
    

}
