<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    function getCreatedAtAttribute($value){
        return Carbon::parse($value)->format('F j, Y h:i A'); // Example: "January 17, 2025 03:24 PM"
    }

    function getUpdatedAtAttribute($value){
        return Carbon::parse($value)->format('F j, Y h:i A'); // Example: "January 17, 2025 03:24 PM"
    }
}
