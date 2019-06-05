<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    //
    public function members()
    {
        return $this->hasMany('App\User');
    }
    
    public function coach()
    {
        // this function facilate work between classes, if not look at similar way to get the coach
        // for an instance $project
        // using this method $coach=$project->coach;  // simple and quick
        // if not  $coach = User::find($project->user_id);
         // also must import the class at begin: use App\User;
        return $this->belongsTo('App\User');
    }
    public function projects()
    {
        // all project recently created and done
        return $this->hasMany('App\Project');
    }
    public function owner()
    {
        if ($this->project_id!=1) {
                $project=Project::find($this->project_id);
                return User::find($project->user_id);
        }
            
        return null;
    }
    public function hasAnswer($set_id)
    {
        foreach ($this->members as $user) {
            if ($user->sets_answered()->get()->pluck('pivot')->where('set_id', 1)->pluck('status')=='done') {
                return true;
            }
        }
        return false;
    }
}
