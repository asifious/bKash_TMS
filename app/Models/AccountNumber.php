<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountNumber extends Model
{
    use HasFactory;

    protected $fillable = ['account_number','account_name','type','status','note'];
}
