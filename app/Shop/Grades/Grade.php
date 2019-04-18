<?php

namespace App\Shop\Grades;

use App\Shop\Students\Student;
use App\Shop\Grades\Grade;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use Notifiable, SoftDeletes, SearchableTrait, Billable;
    
    
  
    
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    protected $dates = ['deleted_at'];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'grades.name' => 10,
        ]
    ];




    public function students()
    {
        $this->hasMany(Student::class);
    }
    
    public function grades()
    {
        $this->hasMany(Grade::class);
    }
}
