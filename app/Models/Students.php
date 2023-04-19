<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Courses;

class Students extends Model
{
    use HasFactory;
    
    protected $fillable = ['name','last_name','age','email','courses'];

    // public function courses (){
    //     return $this->belongsToMany(Courses::class,'courses_students');
    // }

}
