<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameResult extends Model
{
    protected $fillable = ["attempt", "seconds"];

    use HasFactory;
}
