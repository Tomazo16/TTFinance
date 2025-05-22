<?php 

namespace App\Config;

enum TemplateConfig
{
    public static function getBasePath(): string
    {
        return __DIR__ . '/../templates';
    }

    public static function getLayout(): string
    {
        return __DIR__ . '/../templates/base.html.php';
    }

    public static function getStylesPath(): string
    {
        return __DIR__ . '/../assets/css';
    }

    public static function getJsPath(): string
    {
        return __DIR__ . '/../assets/js';
    }
}