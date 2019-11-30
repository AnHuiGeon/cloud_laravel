<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'name', 'birth', 'gender', 'hint', 'answer', 'confirm_code', 'activated',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'confirm_code',
    ];
    // 테이블 내용 조회시 숨겨지는 필드들

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // 'birth' => 'date',
        'activated' => 'boolean',
    ];

    protected $dates = ['last_login'];

    public function local_semesters(){
        return $this -> hasMany(LocalSemester::class);
    }
    
}
