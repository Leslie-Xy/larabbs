<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\{Form, Grid, Show};

class TopicsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '话题';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Topic);

        $grid->id('Id')->sortable();
        $grid->title('标题');
        $grid->user_id('发帖人')->display(function() {
            return '<a href="'.route('admin.users.show', $this->user_id).'" target="_blank">'.$this->user->name.'</a>';
        });
        $grid->category()->name('分类');
        $grid->reply_count('回复数');
        $grid->view_count('查看数')->sortable();
        $grid->created_at('创建时间')->sortable();
        $grid->updated_at('更新时间');

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
        $show = new Show(Topic::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('标题'));
        $show->field('body', __('内容'))->unescape();;
        $show->field('user_id', __('发帖人'));
        $show->field('category_id', __('分类'));
        $show->field('reply_count', __('回复数'));
        $show->field('view_count', __('查看数'));
        $show->field('last_reply_user_id', __('最后登录时间'));
        $show->field('order', __('Order'));
        $show->field('excerpt', __('Excerpt'));
        $show->field('slug', __('Slug'));
        $show->field('created_at', __('创建时间'));
        $show->field('updated_at', __('更新时间'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Topic);

        $form->text('title', __('标题'));
        $form->simditor('body', __('内容'));
        $form->number('user_id', __('发帖人'));
        $form->number('category_id', __('分类'));
        $form->number('reply_count', __('回复数'));
        $form->number('view_count', __('查看数'));
        $form->number('last_reply_user_id', __('最后登录时间'));
        $form->number('order', __('Order'));
        $form->textarea('excerpt', __('Excerpt'));
        $form->text('slug', __('Slug'));

        return $form;
    }

    public function uploadImage(Request $request)
    {
        // 初始化返回数据，默认是失败的
        $data = [
            'success'   => false,
            'msg'       => '上传失败!',
            'file_path' => ''
        ];
        // 判断是否有上传文件，并赋值给 $file
        if ($file = $request->upload_file) {
            // 保存图片到本地
            $result = ImageUploadHandler($request->upload_file, 'topics', 'admin_'.\Auth::id(), 1024);
            // 图片保存成功的话
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg']       = "上传成功!";
                $data['success']   = true;
            }
        }
        return $data;
    }
}
