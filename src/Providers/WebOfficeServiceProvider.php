<?php

namespace Lijiuhui\WebOffice\Providers;

use Lijiuhui\WebOffice\WebOfficeInterface;
use Illuminate\Support\ServiceProvider;


class WebOfficeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // 发布配置文件
        $config_path = realpath(__DIR__ . '/../../config/weboffice.php');
        $this->publishes([
            $config_path => base_path('config/weboffice.php'),
        ], 'weboffice');

        // 加载路由
        $this->loadRoutesFrom(__DIR__ . '/../../routes/wps.php');
    }

    public function register()
    {
        $this->app->singleton(WebOfficeInterface::class, function () {
            $handler = config('weboffice.handler');
            $class = new $handler();
            if (!($class instanceof WebOfficeInterface)) {
                throw new \Exception('weboffice.handler 配置必须继承 WebOfficeInterface 接口');
            }
            return $class;
        });
    }
}
