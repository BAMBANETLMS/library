<?php

namespace BambanetLms\Library\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use BambanetLms\Library\Models\LibraryBooksBorrowed;



class CustomLibraryController extends Controller
{
    public function returnBooks(Request $request)
    {

        LibraryBooksBorrowed::where('id',Bam_Secure($_POST['id']))->update(['status'=> 1]);
        admin_toastr(trans('admin.save_succeeded'));
        return redirect()->back();
    }
}