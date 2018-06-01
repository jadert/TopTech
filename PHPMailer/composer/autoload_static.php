<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit93b31faf6b85f61d4e3180fc22d01431
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit93b31faf6b85f61d4e3180fc22d01431::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit93b31faf6b85f61d4e3180fc22d01431::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
