<?php

namespace App\Admin\Controllers;

use Spatie\Permission\Models\Permission;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\{Form, Grid, Show};

class PermissionsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '权限';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Permission);

        $grid->id('Id');
        $grid->name('名称');
        $grid->guard_name('Guard name');
        $grid->created_at('创建时间');
        $grid->updated_at('更新时间');

        $grid->disableCreateButton();
        $grid->disableActions();
        $grid->tools(function ($tools) {
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
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
        $show = new Show(Permission::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('guard_name', __('Guard name'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Permission);

        $form->text('name', __('Name'));
        $form->text('guard_name', __('Guard name'));

        return $form;
    }
}
