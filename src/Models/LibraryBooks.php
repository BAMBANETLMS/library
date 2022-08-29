<?php

namespace BambanetLms\Library\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibraryBooks extends Model
{
    use HasFactory;

    public function category(){
         return $this->belongsTo('BambanetLms\Library\Models\BamBookCategory','category_id');
    }

    public function school(){
         return $this->belongsTo('App\Models\BamSchool','school_id');
    }
    public function admin(){
        return $this->belongsTo('App\Models\AdminUsers','added_by');
    }
}
