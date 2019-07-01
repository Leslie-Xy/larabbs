<?php
if (!function_exists('appEnv')) {
    /**
     * 获取项目里的ENV配置，之所以加这个函数是因为一旦在部署的时候打开config:cache 就会导致除了configuration files
     * 以外的地方通过Laravel的env函数获取不到.env里配置的环境变量，所以通过这个函数中转一下
     *
     * @param string $key 要获取的环境变量的KEY
     * @param string $default default value for $key
     * @return string
     */
    function appEnv($key, $default = null)
    {
        return config('env.' . $key, $default);
    }
}

if (!function_exists('route_class')) {

    function route_class()
    {
        return str_replace('.', '-', Route::currentRouteName());
    }
}

if (!function_exists('category_nav_active')) {

    function category_nav_active($category_id)
    {
        return active_class((if_route('categories.show') && if_route_param('category', $category_id)));
    }
}

if (!function_exists('make_excerpt')) {
    function make_excerpt($value, $length = 200)
    {
        $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
        return str_limit($excerpt, $length);
    }
}

if (!function_exists('ImageUploadHandler')) {

    function ImageUploadHandler($file, $folder, $file_prefix, $max_width = false)
    {
        $allowed_ext = ["png", "jpg", "gif", 'jpeg'];
        // 构建存储的文件夹规则，值如：uploads/images/avatars/201709/21/
        // 文件夹切割能让查找效率更高。
        $folder_name = "uploads/images/$folder/" . date("Ym/d", time());

        // 文件具体存储的物理路径，`public_path()` 获取的是 `public` 文件夹的物理路径。
        // 值如：/home/vagrant/Code/larabbs/public/uploads/images/avatars/201709/21/
        $upload_path = public_path() . '/' . $folder_name;

        // 获取文件的后缀名，因图片从剪贴板里黏贴时后缀名为空，所以此处确保后缀一直存在
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';

        // 拼接文件名，加前缀是为了增加辨析度，前缀可以是相关数据模型的 ID
        // 值如：1_1493521050_7BVc9v9ujP.png
        $filename = $file_prefix . '_' . time() . '_' . str_random(10) . '.' . $extension;

        // 如果上传的不是图片将终止操作
        if ( ! in_array($extension, $allowed_ext)) {
            return false;
        }

        // 将图片移动到我们的目标存储路径中
        $file->move($upload_path, $filename);

        // 如果限制了图片宽度，就进行裁剪
        if ($max_width && $extension != 'gif') {

            $file_path = $upload_path . '/' . $filename;
            // 先实例化，传参是文件的磁盘物理路径
            $image = \Image::make($file_path);

            // 进行大小调整的操作
            $image->resize($max_width, null, function ($constraint) {

                // 设定宽度是 $max_width，高度等比例双方缩放
                $constraint->aspectRatio();

                // 防止裁图时图片尺寸变大
                $constraint->upsize();
            });

            // 对图片修改后进行保存
            $image->save();
        }

        return [
            'path' => config('app.url') . "/$folder_name/$filename"
        ];
    }
}