<?php

namespace BambanetLms\Library\Http\Controllers;

use BambanetLms\Library\Models\BamBookCategory;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;
use BambanetLms\Library\Actions\RestoreDeleted;

class LibraryBookCategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Book Category';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new BamBookCategory());
        if(!Admin::user()->isRole('administrator')){
            $grid->model()->where('school_id',Admin::user()->school_id);
        }
        $grid->model()->latest();
        $grid->column('id', __('Id'));
        $grid->column('category_name', __('Category name'));

        if(Admin::user()->inRoles(['administrator', 'principal'])){
            $grid->column('school.school_name','School');
            $grid->column('admin.name','Added By');
        }
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->filter(function($filter) {
            $filter->scope('trashed', 'Recycle Bin')->onlyTrashed();
        });
        $grid->batchActions(function ($batch) {
            //$actions->disableDelete();
            //$actions->disableEdit();
            if (isset($_GET['_scope_']) and $_GET['_scope_'] == 'trashed') {
                $batch->add(new RestoreDeleted());
            }
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
        $show = new Show(BamBookCategory::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('category_name', __('Category name'));
        $show->field('school_id', __('School id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
         $show->panel()
            ->tools(function ($tools) {
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
        $form = new Form(new BamBookCategory());

        $form->text('category_name', __('Category name'));
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
