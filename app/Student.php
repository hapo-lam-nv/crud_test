<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = "students";
    protected $fillable = ['id', 'name', 'address', 'school'];
    protected $timestamp = true;
}
