<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    //
    public function coach_creator()
    {
        return $this->belongsTo('App\User');
    }
    public function myquestions()
    {
        return $this->hasMany('App\Question');
    }

    public function users_answered()
    {
        return $this->belongsToMany('App\User')
            ->withTimestamps()->withPivot('status');
        // return $this->belongsToMany('App\User')->as('replacepivot')->withTimestamps()->withPivot('answer');
    }

    // example to retrieve intermediate column which in here answer
    // $set = App\Set::find(1);

    //     foreach ($set->users_answered as $user) {
    //         echo $user->pivot->answer;
    //     }


    // this is a recommended way to declare event handlers
    public static function boot()
    {
        parent::boot();

        static::deleting(
            function ($set) {
                // before delete() method call this
                foreach ($set->myquestions as $quest) {
                    // in there we will remove all links from user_id too
                    $quest->delete();
                }
                // detach all roles from the user
                $set->users_answered()->detach();
            }
        );
    }
}
