<?php

$appsDir = setting("path.apps");

$dh = opendir($appsDir);

while ($file = readdir($dh)) {

    $appPath = $appsDir . "/" . $file;
    $appConfigPath = $appPath . "/app.php";

    if ($file == "." || $file == ".." || !is_dir($appPath) || !file_exists($appConfigPath)) {
        continue;
    }

    $appConfigData = require $appConfigPath;

    containers\AppContainer::registerApplication($appConfigData);

}


