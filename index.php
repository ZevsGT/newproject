<?php
require_once "engine/data/db.php"; // подключение бд + конфиг + шаблонизатор
require_once 'engine/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array(
    //'cache'       => 'engine/cache',
    //'auto_reload' => true
 ));


$tests = R::findAll('testtitle');
$template = $twig->loadTemplate('general.tpl');
echo $template->render(array('tests' => $tests));

?>