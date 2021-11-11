<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     * edit this array if you added attribute to your
     * user to register and must be fillable in your registration
     *  form (using input with same name and yours values)
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'type', 'parentid', 'team_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     * skip idk where in here
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function team()
    {
        return $this->belongsTo('App\Team');
    }

    public function teamscoached()
    {
        // Team have user_id and it mean the coach id
        // so coach can create many teams and here is the relation
        // see in Team model the inverse relation to get the coach of the team
        return $this->hasMany('App\Team');
    }

    public function myprojects()  // special use for product owner
    {
        return $this->hasMany('App\Project');
    }

    public function mysets() // special use for coach
    {
        return $this->hasMany('App\Set');
    }

    public function sets_answered() // special use for members team like
    {
        return $this->belongsToMany('App\Set')->withTimestamps()->withPivot('status');
        // return $this->belongsToMany('App\User')
        //     ->as('replacepivot')->withTimestamps()->withPivot('answer');
    }

    // example to retrieve intermediate column which in here answer
    // $user = App\User::find(1);

    //     foreach ($user->sets_answered as $set) {
    //         echo $set->pivot->answer;
    //     }

    public function questions_asked()
    {
        // return $this->belongsToMany(
        //     'App\Question',
        //     'question_user',
        //     'user_id',
        //     'question_id'
        // )
        //     ->withTimestamps()->withPivot('answer');
        // because i respected default naming i can also use:
        return $this->belongsToMany('App\Question')->withTimestamps()->withPivot('answer');
    }

    // for filtering check url note about filter
    public function question_set_asked($set_id)
    {
        $questions = $this->questions_asked;
        if (count($questions) == 0) {
            return;
        }
        foreach ($questions as $quest) {
            if ($quest->set_id == $set_id) {
                $questions_filtered[] = $quest;
            }
        }
        // $questions_filtered = array_filter($questions, function(Question $quest){
        //        if ($quest->set_id == $set_id) return true;
        //     return true;
        // }
        // );

        return $questions_filtered;
    }
}
