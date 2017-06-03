<?php

namespace BlueBlazeAssociates\Technology\PHP\PHPOnSiteGround;

define('PHP_ON_SITEGROUND__BASE_DIR', __DIR__ . '/../../');

require PHP_ON_SITEGROUND__BASE_DIR. 'vendor/autoload.php';

use Symfony\Component\Console\Application;
use BlueBlazeAssociates\Technology\PHP\PHPOnSiteGround\Commands\Install;

$application = new Application('PHP on SiteGround', '0.0.1');

$command_install = new Install();
$application->add($command_install);

$application->run();

// $twig_loader = new \Twig_Loader_Filesystem(BASE_DIR . 'src/twig');
// $twig        = new \Twig_Environment($twig_loader);

// $twig_template = $twig->load('cli-bin/php4x-cli.twig');

// print $twig_template->render(array('path' => '/home/sandyt19'));




