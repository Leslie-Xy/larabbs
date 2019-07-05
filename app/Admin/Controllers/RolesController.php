<?php

namespace App\Admin\Controllers;

use Spatie\Permission\Models\{Role, Permission};
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\{Form, Grid, Show};

class RolesController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '角色';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Role);

        $grid->id('Id');
        $grid->name('名称');
        $grid->guard_name('Guard name');
        $grid->permissions('权限')->pluck('name')->label();
        $grid->created_at('创建时间');
        $grid->updated_at('更新时间');

        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        $grid->filter(function($filter){

            $filter->disableIdFilter();
            $filter->like('name', '名称');
            $filter->equal('guard_name', 'Guard Name');
            $filter->between('created_at')->datetime();

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
        $show = new Show(Role::findOrFail($id));

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
        $form = new Form(new Role);

        $form->text('name', '名称');
        $form->text('guard_name', 'Guard name');
        $form->listbox('permissions', '权限')->options(Permission::all()->pluck('name', 'id'));

        return $form;
    }
}
