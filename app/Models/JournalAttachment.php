<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalAttachment extends Model
{
    //

    use HasFactory;

    protected $fillable = [
        'journal_id', 'file_path', 'file_type'
    ];

    public function journal(){
        return $this->belongsTo(Journal::class);
    }
}
