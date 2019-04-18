<?php

namespace App\Shop\Students;

use App\Shop\Professors\Professor;
use App\Shop\Schools\School;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;
use Nicolaslopezj\Searchable\SearchableTrait;


class Student extends Authenticatable
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
        'status',
        'school_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    protected $dates = [];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'students.name' => 10,
            'students.email' => 5
        ]
    ];




    public function professor()
    {
        return $this->belongsToMany(Professor::class);
    }
    
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
