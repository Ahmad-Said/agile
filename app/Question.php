<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //  must remove user_id because set already have coach
    public function set()
    {
        return $this->belongsTo('App\Set');
    }
    public function usersAsked()
    {
        return $this->belongsToMany('App\User')
            ->withTimestamps()
            ->withPivot('answer');
    }

    // this is a recommended way to declare event handlers
    public static function boot()
    {
        parent::boot();

        static::deleting(
            function ($quest) {
                // before delete() method call this
                // back to set all user asked set to pending
                $set=$quest->set;
                foreach ($set->users_answered as $user) {
                    $user->sets_answered()->updateExistingPivot($set->id, ['status' => 'pending']);
                }

                $quest->users_asked()->detach();
            }
        );
    }
}
