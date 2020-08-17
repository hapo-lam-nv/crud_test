<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    protected $dates = ['delete_at'];
    protected $table = "students";
    protected $fillable = ['id', 'name', 'address', 'school'];
    protected $timestamp = true;
}
