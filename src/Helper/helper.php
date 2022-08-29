<?php
//book category
function Bam_BookCategory($type = 'all',$id = 0,$admin_school = 0){

    if($type == 'all'){
       return DB::table('bam_book_categories')->where('school_id',$admin_school)->get();
    }else if($type == 'plucked'){
        return DB::table('bam_book_categories')->where('school_id',$admin_school)->get()->pluck('category_name','id');
    }else{
        return DB::table('bam_book_categories')->where('id',$id)->first();
    }
}

//books
function Bam_Books($type = 'all',$id = 0,$admin_school = 0){

    if($type == 'all'){
       return DB::table('library_books')->where('school_id',$admin_school)->get();
    }else if($type == 'plucked'){
        return DB::table('library_books')->where('school_id',$admin_school)->get()->pluck('name','id');
    }else{
        return DB::table('library_books')->where('id',$id)->first();
    }
}