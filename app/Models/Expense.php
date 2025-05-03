<?php

namespace App\Models;

use App\Models\User;
use App\Models\Company;
use App\Observers\ExpenseObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([ExpenseObserver::class])]

class Expense extends Model
{
    use HasFactory;

    protected $fillable = ['title','amount','category','user_id','company_id'];

    // protected guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function company() {
        return $this->belongsTo(Company::class);
    }
}
