<?php

namespace Yousef\SearchEngine;

use Yousef\SearchEngine\Engines\ElasticSearchEngine;

class SearchEngineManager
{
    /**
     * @throws Exception
     */
    public function getDriver(): \Yousef\SearchEngine\Engines\ElasticSearchEngine
    {
        return $this->createElasticSearchDriver();
    }

    /**
     * @throws Exception
     */
    public function createElasticSearchDriver(): \Yousef\SearchEngine\Engines\ElasticSearchEngine
    {
        $this->ensureElasticSearchClientIsInstalled();

        $config = (include('./config/search-engine.php'))['elasticsearch'];

        $client = \Elastic\Elasticsearch\ClientBuilder::create()->setHosts([$config['host']]);

        if ($user = $config['username']) {
            $client->setBasicAuthentication($user, $config['password']);
        }

        if ($cloudId = $config['cloud_id']) {
            $client->setElasticCloudId($cloudId)
                ->setApiKey($config['api_key']);
        }
        return new ElasticSearchEngine($client->build());
//        return new Yousef\SearchEngine\Engines\ElasticSearchEngine($client->build());

    }

    /**
     * @throws Exception
     */
    public function ensureElasticSearchClientIsInstalled(): void
    {
        if (class_exists(\Elastic\Elasticsearch\Client::class)) {
            return;
        }

        if (class_exists('Elastic\Elasticsearch\Client')) {
            throw new Exception('Please install the ElasticSearch client: elastic/elasticsearch-client-php.');
        }
    }

}