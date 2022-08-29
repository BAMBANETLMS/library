<?php

namespace BambanetLms\Library;
use Encore\Admin\Admin;
use BambanetLms\Library\Http\Controllers\LibraryBookCategoryController;
use BambanetLms\Library\Http\Controllers\LibraryBooksController;
use BambanetLms\Library\Http\Controllers\LibraryBooksBorrowedController;

trait BootExtension 
{
    public static function boot()
    {
        static::registerRoutes();

        Admin::extend('library', __CLASS__);
    }

    protected static function registerRoutes()
    {
        parent::routes(function ($router) {
            /* @var \Illuminate\Routing\Router $router */
            //Book Categories
            $router->resource('library/book-category', LibraryBookCategoryController::class);
            //Library Books
            $router->resource('bam-library-books', LibraryBooksController::class);
            //Borrowed Books
            $router->resource('library-books-borroweds', LibraryBooksBorrowedController::class);
            //Bambanet Post Mark Book Returned
            $router->post('/alllibrarybooks/returnbook', 'HomeController@returnBooks')->name('library.returnbooks');
            
        });
    }

    
}