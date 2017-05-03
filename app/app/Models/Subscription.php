<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $guarded = [];
    
    protected $table;

    public function owner()
    {
    }
}