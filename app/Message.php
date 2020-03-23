<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function users(){
        return $this->belongsTo(User::class );
    }

    public function channels(){
        return $this->belongsTo(Channel::class );
    }
}
