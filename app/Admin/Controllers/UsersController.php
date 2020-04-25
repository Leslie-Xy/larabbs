<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\{Form, Grid, Show};

class UsersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '用户管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User);

        $grid->id('Id');
        $grid->avatar('头像')->image(config('app.url'), 50, 50);
        $grid->name('姓名');
        $grid->roles('角色')->pluck('name')->label();
        $grid->email('邮箱');
        $grid->created_at('注册时间');
        $grid->last_actived_at('最后活跃时间');

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
        $show = new Show(User::findOrFail($id));

        $show->id('Id');
        $show->avatar('头像')->image(config('app.url'), 50, 50);
        $show->name('姓名');
        $show->email('邮箱');
        $show->weixin_openid('微信 openid');
        $show->weixin_unionid('微信 unionid');
        $show->created_at('注册时间');
        $show->updated_at('更新时间');
        $show->introduction('简介');
        $show->last_actived_at('最后活跃时间');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User);

        $form->text('name', '姓名')->rules('required|between:3,25');
        $form->email('email', '邮箱')->rules(function ($form) {
            return 'required|unique:users,email,'.$form->model()->id    ;
        });
        $form->password('password', '密码')->placeholder('输入 重置密码');
        $form->image('avatar', '头像')->move('/uploads/images/avatars/');
        $form->text('introduction', '简介');
        $form->multipleSelect('roles', '角色')->options(Role::all()->pluck('name', 'id'));

        $form->saving(function (Form $form) {
            if ($form->password) {
                $form->password = bcrypt($form->password);
            }
        });

        return $form;
    }
}
