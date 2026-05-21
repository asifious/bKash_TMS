<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','invoice_no','invoice_date','customer_name','account_number','description','amount','note'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
