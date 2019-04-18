<?php

namespace App\Shop\Professors;

use App\Shop\Students\Student;
use App\Shop\Grades\Grade;
use App\Shop\Schools\School;
use App\Shop\Professors\Professor;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;
use Nicolaslopezj\Searchable\SearchableTrait;

class Professor extends Authenticatable
{
    use Notifiable, SoftDeletes, SearchableTrait, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'professors.name' => 10,
            'professors.email' => 5
        ]
    ];


    public function school() {
        return $this->belongsTo(School::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
    
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
