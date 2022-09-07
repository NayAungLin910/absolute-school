<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'teacher_id',
        'batch_id',
        'admin_id',
        'moderator_id',
        'meeting_id',
        'meeting_password',
        'meeting_link',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function moderator()
    {
        return $this->belongsTo(Moderator::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function section()
    {
        return $this->hasMany(Section::class);
    }

    public function form()
    {
        return $this->hasMany(Form::class);
    }

}
