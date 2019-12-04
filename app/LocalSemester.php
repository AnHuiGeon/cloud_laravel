<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocalSemester extends Model
{
    protected $fillable = ['title', 'content'];

    public function user(){
        return $this -> belongsTo(User::class);
    }
}
// App\User::find(1)->local_semesters()->create(['title'=>'first title', 'content'=>'first content',]);