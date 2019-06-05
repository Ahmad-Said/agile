<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MypChart extends Model
{
    //
    private static $FontPath;
    public static function init()
    {
        // initialize Font path :
        $fontpath= base_path();
        // $fontpath=str_replace("\\","/",$fontpath);
        $fontpath.="/vendor/bozhinov/pchart/pChart/fonts/";
        self::setFontPath($fontpath);
    }
    public static function setFontPath($fontpath)
    {
        self::$FontPath=$fontpath;
    }
    public static function getFontPath()
    {
        self::init();
        return self::$FontPath;
    }
}
