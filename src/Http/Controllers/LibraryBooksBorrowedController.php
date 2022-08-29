<?php

namespace BambanetLms\Library\Http\Controllers;

use BambanetLms\Library\Models\LibraryBooksBorrowed;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\BamSchool;
use App\Models\BamAcademicStudents;
use BambanetLms\Library\Models\LibraryBooks;
use BambanetLms\Library\Models\BamBookCategory;
use App\Models\BamAcademicTeachers;
use Encore\Admin\Facades\Admin;


class LibraryBooksBorrowedController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Borrowed Books';    

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new LibraryBooksBorrowed());

        if(!Admin::user()->isRole('administrator')){
            $grid->model()->where('school_id',Admin::user()->school_id);
        }
        
        $grid->model()->latest();
        $grid->column('id', __('Action'))->display(function($id){
            if($this->status != 1){
                return '<form method="POST" action="'.url('/admin/alllibrarybooks/returnbook').'">
                    <input type="hidden"  name="_token" value="'.csrf_token().'">
                    <input type="hidden"  name="id" value="'.$id.'">
                    <button class="btn btn-sm btn-primary returned-book" type="submit" data-id="'.$this->id.'">Return</button>
                </form>';

            }
            if($this->status == 1){
                return 'Book Returned';
            }

        })->label();

        $grid->column('type', __('Type'))->using([
            'S' => 'Student',
            'T' => 'Teacher'
        ]);
        

        $grid->column('user_id', __('User'))->display(function(){
            if($this->type == 'S'){
                $data = BamAcademicStudents::where('id',$this->user_id)->first();
                return $data->other_names.' ('.$data->roll_no.')';
            }else{
                $data = BamAcademicTeachers::where('id',$this->user_id)->first();
                return $data->name.' ('.$data->teacher_number.')';
            }

        });
        $grid->column('book_id', __('Book '))->display(function(){
            $data = LibraryBooks::where('id',$this->book_id)->first();
            $category = BamBookCategory::where('id',$data->category_id)->first();
            return $data->name.' ('.$category->category_name.')';
        });
        if(Admin::user()->inRoles(['administrator', 'principal'])){
            $grid->column('school.school_name','School');
            $grid->column('admin.name','Added By');
        }

        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
         $grid->actions(function ($actions) {
            $actions->disableDelete();
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
        $show = new Show(LibraryBooksBorrowed::findOrFail($id));

        /**$show->field('id', __('Id'));
        $show->field('type', __('Type'));
        $show->field('user_id', __('User id'));
        $show->field('book_id', __('Book id'));
        $show->field('school_id', __('School id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));**/
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
        $form = new Form(new LibraryBooksBorrowed());

        $form->select('type', __('Type'))->default('S')->options([
            'S' => 'Student',
            //'T' => 'Teacher'
        ])->when('S',function(Form $form){
            $form->select('user_id', __('Student'))->options(Bam_Students('plucked',0,Admin::user()->school_id))->required();;
        })->required();

        $form->select('book_id', __('Book'))->default(1)->options(Bam_Books('plucked',0,Admin::user()->school_id))->required();
        if(Admin::user()->isRole('administrator')){
            $form->select('school_id', __('School'))->options(Bam_SchoolPluckedNames())->default(1)->required();
        }else{
            $form->hidden('school_id', __('School'))->value(Admin::user()->school_id)->readonly();
        }
        $form->hidden('added_by', __('Added By'))->value(Admin::user()->id)->readonly();
        $form->tools(function (Form\Tools $tools) {
                $tools->disableDelete();
                $tools->disableView();
                //$tools->disableList();
            });
        return $form;
    }
}
