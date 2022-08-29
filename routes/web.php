<?php

use BambanetLms\Library\Http\Controllers\LibraryController;

Route::get('library', LibraryController::class.'@index');