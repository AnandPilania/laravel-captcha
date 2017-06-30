<?php

namespace A\Captcha;

use Illuminate\Support\Facades\Session;

/**
 * Class Captcha
 * @package AP\Captcha
 */
class Captcha
{
    /**
     * @var
     */
    protected static $code;

    /**
     * @var string
     */
    protected static $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * @param int $length
     * @param bool $html
     * @return string
     */
    public static function build($length = 4, $html = false)
    {
        Session::put('captcha', static::generate($length));

        return $html ? '<div class="captcha"><span style="background:#2a88bd;color:#fff;padding:5px;border:1px solid #216a94;position:relative;">'.static::$code.'<i style="background:#216a94;font-style:normal;overflow:hidden;position:absolute;top:-1px;right:-21px;width:20px;height:100%;line-height:26px;cursor:pointer;text-align:center;border:1px solid #216a94;border-left:none;">R</i></span><br/><input maxlength="'.$length.'" type="text" name="captcha_code" id="captcha_code" /></div>' : static::$code;
    }

    /**
     * @param $value
     * @return bool
     */
    public static function verify($value)
    {
        if(empty($value) && !Session::has('captcha')){
            return false;
        }

        if(Session::get('captcha') === $value){
            Session::forget('captcha');
            return true;
        }

        return false;
    }

    /**
     * @param int $length
     * @return string
     */
    public static function refresh($length = 4)
    {
        return static::build($length);
    }

    /**
     * @param $length
     * @return string
     */
    protected static function generate($length)
    {
        Session::forget('captcha');
        return static::$code = substr(str_shuffle(str_repeat(static::$pool, 5)), 0, $length);
    }
}