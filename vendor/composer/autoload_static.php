<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit26afb3b5aad23148f84cff7d3b526d21
{
    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'RESO\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'RESO\\' => 
        array (
            0 => __DIR__ . '/..' . '/reso/reso-php/lib',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit26afb3b5aad23148f84cff7d3b526d21::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit26afb3b5aad23148f84cff7d3b526d21::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
