<?php

declare(strict_types=1);

session_start();

spl_autoload_register(function (string $nameSpace) {
    $path = str_replace(['\\', 'App/'], ['/', ''], $nameSpace);
    $path = "src/$path.php";
    require_once($path);
});

$configuration = require_once("config/config.php");

use App\Request;
use App\Controller\NoteController;
use App\Exception\AppException;
use App\Exception\ConfigurationException;



$request = new Request($_GET, $_POST, $_SERVER);

try {
    NoteController::initConfig($configuration);
    (new NoteController($request))->run();
} catch (ConfigurationException $e) {
    echo '<h1>Wystąpił błąd</h1>';
    echo 'Problem z konfiguracją. Skontakuj się z administratorem.';
} catch (AppException $e) {
    echo '<h1>Wystąpił błąd</h1>';
    echo '<h2>' . $e->getMessage() . '</h2>';
} catch (Throwable $e) {
    echo '<h1>Wystąpił błąd</h1>';
}
