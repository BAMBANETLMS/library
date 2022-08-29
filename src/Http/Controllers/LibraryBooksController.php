<?php

namespace BambanetLms\Library\Http\Controllers;

use BambanetLms\Library\Models\LibraryBooks;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use BambanetLms\Library\Models\BamBookCategory;
use Encore\Admin\Facades\Admin;

class LibraryBooksController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Library Books';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new LibraryBooks());
            
        if(!Admin::user()->isRole('administrator')){
            $grid->model()->where('school_id',Admin::user()->school_id);
        }
        $grid->model()->latest();
        $grid->column('id', __('Id'));
        $grid->column('category.category_name', __('Category'));
        $grid->column('name', __('Name'));
        $grid->column('number', __('Number of Books'));
        if(Admin::user()->inRoles(['administrator', 'principal'])){
            $grid->column('school.school_name','School');
            $grid->column('admin.name','Added By');
        }
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->actions(function ($actions) {
            //$actions->disableDelete();
            //$actions->disableEdit();

        });
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(LibraryBooks::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('category_id', __('Category id'));
        $show->field('name', __('Name'));
        $show->field('school_id', __('School id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->panel()->tools(function ($tools) {
               // $tools->disableEdit();
                //$tools->disableList();
                $tools->disableDelete();
        });
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new LibraryBooks());
        $form->select('category_id', __('Category'))->options(Bam_BookCategory('plucked',0,Admin::user()->school_id));
        $form->text('name', __('Name'));
        $form->text('number', __('Number of Books'));
        if(Admin::user()->isRole('administrator')){
            $form->select('school_id', __('School'))->options(Bam_SchoolPluckedNames())->default(1)->required();
        }else{
            $form->hidden('school_id', __('School'))->value(Admin::user()->school_id)->readonly();
        }
        $form->hidden('added_by', __('Added By'))->value(Admin::user()->id)->readonly();
        //$form->number('school_id', __('School id'))->default(1);
        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
                //$tools->disableList();
        });
        return $form;
    }
}
