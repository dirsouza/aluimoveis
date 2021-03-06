<?php

setlocale(LC_ALL, "pt_BR", "pt_BR-utf-8", "portuguese");

require_once "vendor/autoload.php";

session_start();

use Slim\Slim;
use ALUImoveis\Models\Login;

$app = new Slim();
$app->config(array(
    'debug' => true,
    'templates.path' => 'views',
    'mode' => 'development'
));

$app->get('/', function() use ($app) {
    Login::verifyLogin();

    $user = new Login();
    $user->getUser((int) $_SESSION[Login::SESSION]['idUser']);

    $_SESSION['page'] = "dashboard";

    $app->render('default/header.php', $user->getValues());
    $app->render('default/panel.php');
    $app->render('default/view.php');
    $app->render('default/footer.php');
});

require_once "routes/login.php";
require_once "routes/locator.php";
require_once "routes/renter.php";
require_once "routes/immobile.php";
require_once "routes/contract.php";
require_once "routes/discount.php";
require_once "routes/receipt.php";

$app->run();