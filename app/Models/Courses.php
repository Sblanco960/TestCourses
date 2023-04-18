<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Students;

class Courses extends Model
{
    use HasFactory;

    protected $fillable = ['name_course','schedule','start_date','end_date'];

    public function students (){
        return $this->belongsToMany(Students::class,'courses_students');
    }

}
