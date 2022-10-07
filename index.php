<?php

use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Database\Capsule\Manager as Capsule;
use Yousef\SearchEngine\Jobs\Import;
use Yousef\SearchEngine\Searchable\ImportSourceFactory;

require 'vendor/autoload.php';

$config = (include('./config/search-engine.php'))['elasticsearch'];

$capsule = new Capsule;

$capsule->addConnection([
    'driver' => 'mysql',
    'host' => '127.0.0.1',
    'database' => 'marketplace',
    'port' => '3306',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => 'mp_',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();
//
//var_dump(\Yousef\SearchEngine\models\User::query()->first());die();

try {
//    $driver = (new \Yousef\SearchEngine\SearchEngineManager())->getDriver();
    $client = \Elastic\Elasticsearch\ClientBuilder::create()->setHosts([$config['host']]);
//    $driver->update(\Yousef\SearchEngine\models\User::query()->get());


    $source = \Yousef\SearchEngine\Searchable\DefaultImportSourceFactory::from(\Yousef\SearchEngine\models\Product::class);
    $job = new Import($source);
    ($job)->handle($client->build());
//    ($job)->allOnQueue($source->syncWithSearchUsingQueue())
//        ->allOnConnection($source->syncWithSearchUsing());

} catch (Exception $e) {
    var_dump($e);die('some thing wrong');
}