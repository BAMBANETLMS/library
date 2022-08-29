<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBookStatusToLibraryBooksBorroweds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('library_books_borroweds', function (Blueprint $table) {
            //
            $table->string('status')->default(0)->after('school_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('library_books_borroweds', function (Blueprint $table) {
            //
        });
    }
}
