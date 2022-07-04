<?php

spl_autoload_register('myAutoLoader');

function myAutoLoader(string $className): void
{

    $path = ['classes/', ''];
    $extension = '.php';

    $found = false;

    for ($i = 0; !$found && $i < count($path); $i++) {

        $fullPath = $path[$i] . $className . $extension;

        $found = file_exists($fullPath);

        if ($found) {
            include_once $fullPath;
        }
    }
}