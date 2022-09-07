<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'subject_id',
    ];

    public function subject(){
        return $this->belongsTo(Subject::class);
    }

    public function file(){
        return $this->hasMany(File::class);
    }
}
