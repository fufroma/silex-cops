<?php
// @codeCoverageIgnoreStart
$app = new \Cops\Model\Application();

// Define core model, no closure to ensure loading
// Load configuration & set service providers
$app['core'] =  new \Cops\Model\Core(BASE_DIR.'app/cops/config.ini', $app);

$app['debug'] = true;

// Register special database for tests
$app->register(new \Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'        => 'pdo_sqlite',
        'path'          => DATABASE,
        'driverOptions' => \Cops\Model\Calibre::getDBInternalFunctions(),
    ),

));

$app['book_storage_dir'] = BASE_DIR.'tests/data';

return $app;
// @codeCoverageIgnoreEnd