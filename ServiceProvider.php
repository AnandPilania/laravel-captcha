<?php

namespace AP\Captcha;

use Illuminate\Support\ServiceProvider as Base;

class ServiceProvider extends Base
{
    protected $defer = false;

    /**
     * @var string
     */
    protected $captchaFailedRespone = 'Captcha validation failed!!';

    public function boot()
    {
        $app = $this->app;

        $app['validator']->extend('captcha', function ($attribute, $value) use ($app) {
            return $app['captcha']->verify($value);
        }, $this->captchaFailedRespone);

        if ($app->bound('form')) {
            $app['form']->macro('captcha', function ($attributes = []) use ($app) {
                return $app['captcha']->display($attributes, $app->getLocale());
            });
        }

        $this->registerRoutes($app);
    }

    public function register()
    {
        $this->app->singleton('captcha', Captcha::class);
    }

    /**
     * @param $app
     */
    protected function registerRoutes($app)
    {
        $app['router']->group(['prefix' => 'captcha', 'middleware' => 'web'], function ($router) use ($app){
			$router->get('/widget/{length?}', function($length = 4) {
				return Captcha::build($length, true);
			});
            $router->get('/refresh', function() use($app){
                return response()->json(['captcha_code' => Captcha::refresh(count($app['request']->captcha_length))]);
            });
            $router->get('/verify', function() use($app){
                return response()->json(['captcha_verification' => Captcha::verify($app['request']->captcha_code)]);
            });
        });
    }
}