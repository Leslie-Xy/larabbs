<?php

namespace App\Admin\Controllers;

use App\Models\Blog;
use Encore\Admin\{Controllers\AdminController, Form, Grid, Show};
use Illuminate\Http\Request;

class BlogController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '博客';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Blog);
        $grid->id('ID');
        $grid->title('标题');
        $grid->content('内容');
        $grid->ip('IP');
        $grid->author('作者');
        $grid->created_at('创建时间');
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
        $show = new Show(Blog::findOrFail($id));
        $show->id('ID');
        $show->title('标题');
        $show->content('内容');
        $show->ip('IP');
        $show->author('作者');
        $show->created_at('创建时间');
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Blog);
        $form->text('title', '标题')->rules('required');
        $form->text('content', '内容')->rules('required');
        $ip = app(Request::class)->getClientIp();
        $form->ip = $ip;
        $form->text('author', '作者')->rules('required');
        return $form;
    }
}
