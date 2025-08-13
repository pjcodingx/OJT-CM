<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Journal extends Model
{
    //

    use HasFactory, Notifiable;

    protected $fillable = [
        'student_id', 'journal_date', 'content'
    ];

    public function attachments(){
        return $this->hasMany(JournalAttachment::class);
    }

    public function student(){
        return $this->belongsTo(Student::class);
    }
}
