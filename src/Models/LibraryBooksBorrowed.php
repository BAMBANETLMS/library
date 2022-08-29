<?php

namespace BambanetLms\Library\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LibraryBooksBorrowed extends Model
{
    use HasFactory;
    use SoftDeletes;
    public function borrower(){
         return $this->belongsTo('App\Models\BamSchool','school_id');
    }
    public function school(){
         return $this->belongsTo('App\Models\BamSchool','school_id');
    }
    public function admin(){
        return $this->belongsTo('App\Models\AdminUsers','added_by');
    }
}
