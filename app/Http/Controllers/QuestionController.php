<?php

namespace App\Http\Controllers;

use App\Set;
use Validator;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Exists;

class QuestionController extends Controller
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
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->type !== 'coach') {
            return redirect('/home')->with('error', 'Unauthorized Page');
        }

        return view('question.create');
    }
    public function finalcreate(Request $request)
    {
        // return $request->all();
        return view('question.create')->with('data', $request->all());
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
        $a = $request->session()->get('set_id');
        // OR use session('set_id');
        /// use session()->get('set_id');
        // $request->session()->forget('set_id');

        $v = Validator::make(
            $request->all(),
            [
                'type' => "required",
                'body' => 'required',
            ]
        );
        if ($v->fails()) {
            return redirect()->back()->withErrors($v)->withInput();
        }

        if (!($a)) {
            return redirect('/set')
                ->with('error', 'Add question after choosing a set');
        }

        // Create Post
        $question = new Question;
        $question->type = $request->input('type');
        $question->body = $request->input('body');
        if (
            $request->input('type') === 'radiochoice'
            || $request->input('type') === 'select'
        ) {
            $question->options = implode(';', $request->input('options'));
        } else {
            $question->options = $request->input('count');
        }
        $question->set_id = $a;

        $label = $request->input('label');
        if ($label != null && $label != "") {
            $question->label = $label;
        } else {
            $question->label = $question->id;
        }

        $question->save();


        // resolve if set has added a new question all user must fill form again so:
        $set = $question->set;
        // $myrequest= new Request;
        //  i will send form again to users with newly created questions
        // $myrequest['set_id']=$set->id;
        // $members=array();
        foreach ($set->users_answered as $user) {
            $user->sets_answered()->updateExistingPivot($a, ['status' => 'pending']);
            $user->questions_asked()->attach($question->id);
            // caused a problem to
            // $user->sets_answered()->detach($a);
            // $members[]=$user->id;
            // $exist="You may need to send form again";
        }
        // $myrequest['members']=$members;
        // $set->SendForm($myrequest);
        $request->session()->forget('set_id');
        return redirect("/set/$a")
            ->with(
                'success',
                'Question Created Successfully!<br>'
                    . 'And Form sent again to the users with updates'
            );
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
        // code here
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
        $quest = Question::find($id);
        $quest->delete();
        return redirect()->back()
            ->with(
                'success',
                "Question Deleted Successfully!<br>"
                    . "<small>Note: This will reset all user data and submitted"
                    . " form as Their status will be pending again"
            );
    }
}
