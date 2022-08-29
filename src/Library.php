<?php

namespace BambanetLms\Library;

use Encore\Admin\Extension;

class Library extends Extension
{

    use BootExtension;

    /**public $name = 'library';

    public $views = __DIR__.'/../resources/views';

    public $assets = __DIR__.'/../resources/assets';

    public $menu = [
        'title' => 'Library',
        'path'  => 'library',
        'icon'  => 'fa-gears',
    ];**/

    public static function import(){
        $submenu = array (
            array('title'=>'Category','path'=>'library/book-category','icon'=>'fa-arrow-right'),
            array('title'=>'Books','path'=>'bam-library-books','icon'=>'fa-arrow-right'),
            array('title'=>'Borrowed','path'=>'library-books-borroweds','icon'=>'fa-arrow-right')
        );
        parent::createMenu('Library','/','fa-book',0,$submenu);
            
            //parent::createPermission('Media manager', 'ext.media-manager', 'media*');
        
    }
}