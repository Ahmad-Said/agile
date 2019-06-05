<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    // note we do define between model the inverse of relations ships belongto
    // we mean by team_id the team who worked this project till it finishes
    // and we mean by project_id in team the current working project ..
    
    public function team()
    {
        //                      (Model name) and it automaticly detect the Project model have team_id
        // model_id as foreign key so no need to precise
        return $this->belongsTo('App\Team');
    }
    
    
    
    public function owner()
    {
        // even i have defined user_id in my table it failed to return the owner so i precise key just in case idk
        //                      (Model name , foreign key in model)
        return $this->belongsTo('App\User', 'user_id');
    }
}
