<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function student(){
        return $this->belongsToMany(User::class, 'batch_user');
    }

    public function subject(){
        return $this->hasMany(Subject::class);
    }
}
