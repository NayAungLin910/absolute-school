<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "file_path",
        "form_id",
        "user_id",
    ];

    public function form(){
        return $this->belongsTo(Form::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
