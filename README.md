# Elastic Search

[![Latest Stable Version](http://poser.pugx.org/yousef/payment-gateway/v)](https://packagist.org/packages/yousef/payment-gateway) [![Total Downloads](http://poser.pugx.org/yousef/payment-gateway/downloads)](https://packagist.org/packages/yousef/payment-gateway) [![Latest Unstable Version](http://poser.pugx.org/yousef/payment-gateway/v/unstable)](https://packagist.org/packages/yousef/payment-gateway) [![License](http://poser.pugx.org/yousef/payment-gateway/license)](https://packagist.org/packages/yousef/payment-gateway) [![PHP Version Require](http://poser.pugx.org/yousef/payment-gateway/require/php)](https://packagist.org/packages/yousef/payment-gateway)

Simple elasticsearch, and other driver integration.

## Installation

Install via composer

```shell
composer require yousef/elastic-search
```

## Configuration

Add the config in your entry point `config/search-engine.php` file.

```php
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Search Engine
    |--------------------------------------------------------------------------
    |
    | This option controls the default search connection that gets used
    | This connection is used when syncing all models
    | to the search service. You should adjust this based on your needs.
    |
    | Supported: "elasticsearch"
    |
    */

    'driver' => 'elasticsearch',

    /*
    |--------------------------------------------------------------------------
    | Index Prefix
    |--------------------------------------------------------------------------
    |
    | Here you may specify a prefix that will be applied to all search index
    | This prefix may be useful if you have multiple
    | "tenants" or applications sharing the same search infrastructure.
    |
    */

    'prefix' => '',

    /*
    |--------------------------------------------------------------------------
    | Queue Data Syncing
    |--------------------------------------------------------------------------
    |
    | This option allows you to control if the operations that sync your data
    | with your search engines are queued. When this is set to "true" then
    | all automatic data syncing will get queued for better performance.
    |
    */

    'queue' => false,

    /*
    |--------------------------------------------------------------------------
    | Database Transactions
    |--------------------------------------------------------------------------
    |
    | This configuration option determines if your data will only be synced
    | with your search indexes after every open database transaction has
    | been committed, thus preventing any discarded data from syncing.
    |
    */

    'after_commit' => false,

    /*
    |--------------------------------------------------------------------------
    | Chunk Sizes
    |--------------------------------------------------------------------------
    |
    | These options allow you to control the maximum chunk size when you are
    | mass importing data into the search engine. This allows you to fine
    | tune each of these chunk sizes based on the power of the servers.
    |
    */

    'chunk' => [
        'searchable' => 500,
        'unsearchable' => 500,
    ],

    /*
    |--------------------------------------------------------------------------
    | Soft Deletes
    |--------------------------------------------------------------------------
    |
    | This option allows to control whether to keep soft deleted records in
    | the search indexes. Maintaining soft deleted records can be useful
    | if your application still needs to search for the records later.
    |
    */

    'soft_delete' => false,

    /*
    |--------------------------------------------------------------------------
    | ElasticSearch Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your ElasticSearch settings. ElasticSearch is an open
    | source search engine with minimal configuration. Below, you can state
    | the host and key information for your own ElasticSearch installation.
    |
    */

    'elasticsearch' => [
        'host' => 'http://localhost:9200',
        'username' => null,
        'password' => null,
        'cloud_id' => null,
        'api_key' => null,
        'indices' => [
            'mappings' => [
                'default' => [
                    'properties' => [
                        'id' => [
                            'type' => 'keyword',
                        ],
                    ],
                ],
            ],
            'settings' => [
                'default' => [
                    'number_of_shards' => 1,
                    'number_of_replicas' => 0,
                ],
            ],
        ],
    ],

];

```

## Usage

```php
<?php
   try {
    $client = \Elastic\Elasticsearch\ClientBuilder::create()->setHosts([$config['host']]);
    $source = \Yousef\SearchEngine\Searchable\DefaultImportSourceFactory::from(\Yousef\SearchEngine\models\Product::class);
    $job = new Import($source);
    ($job)->handle($client->build());

} catch (Exception $e) {
    var_dump($e);die('some thing wrong');
}
```
## Getting Help

If you're stuck getting something to work, or need to report a bug, please [post an issue in the Github Issues for this project](https://github.com/yousefdev20/laravel-payment-gateway/issues).
## Contributing

If you're interesting in contributing code to this project, clone it by running:

```shell
git clone git@github.com:yousefdev20/elastic-search.git
```

## License

This project is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).