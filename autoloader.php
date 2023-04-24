<?php
final class Autoloader
{
    public static function register(): void
    {
        spl_autoload_register(function ($class) {
            echo $class . "<br>";
            $file = __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
            echo $file;
            if (file_exists($file)) {
                echo "file exists";
                require $file;
                return true;
            }
            return false;
        });
    }
}

echo __DIR__ . '<br>';
Autoloader::register();

?>