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