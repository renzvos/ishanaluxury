<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7780f80e07bb8c4676b6d56ad8bc7cbd
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'MyApp\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'MyApp\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit7780f80e07bb8c4676b6d56ad8bc7cbd::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit7780f80e07bb8c4676b6d56ad8bc7cbd::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
