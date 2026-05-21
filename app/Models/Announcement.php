<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = ['title','message','status','expire_at','created_by'];

    protected $dates = ['expire_at','created_at','updated_at'];
}
