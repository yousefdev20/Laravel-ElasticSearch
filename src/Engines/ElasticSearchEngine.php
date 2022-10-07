<?php

namespace Yousef\SearchEngine\Engines;

use Elastic\Elasticsearch\Exception\ServerResponseException;
use Yousef\SearchEngine\ElasticSearch\Params\Bulk;
use Yousef\SearchEngine\ElasticSearch\Params\Indices\Refresh;
use ONGR\ElasticsearchDSL\Query\MatchAllQuery;
use ONGR\ElasticsearchDSL\Search;
use Yousef\SearchEngine\ElasticSearch\Params\Search as SearchParams;

final class ElasticSearchEngine extends Engine
{
    /**
     * The ElasticSearch client.
     *
     * @var \Elastic\Elasticsearch\Client
     */
    protected $elasticsearch;

    /**
     * Create a new engine instance.
     *
     * @param  \Elastic\Elasticsearch\Client  $elasticsearch
     * @return void
     */
    public function __construct(\Elastic\Elasticsearch\Client $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    /**
     * {@inheritdoc}
     */
    public function update($models)
    {
        $params = new Bulk();
        $params->index($models);
        $response = $this->elasticsearch->bulk($params->toArray())->asArray();
        if (array_key_exists('errors', $response) && $response['errors']) {
            $error = new ServerResponseException(json_encode($response, JSON_PRETTY_PRINT));
            throw new \Exception('Bulk update error', $error->getCode(), $error);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function delete($models)
    {
        $params = new Bulk();
        $params->delete($models);
        $this->elasticsearch->bulk($params->toArray());
    }

    /**
     * {@inheritdoc}
     */
    public function flush($model)
    {
        $indexName = $model->searchableAs();
        $exist = $this->elasticsearch->indices()->exists(['index' => $indexName])->asBool();
        if ($exist) {
            $body = (new Search())->addQuery(new MatchAllQuery())->toArray();
            $params = new SearchParams($indexName, $body);
            $this->elasticsearch->deleteByQuery($params->toArray());
            $this->elasticsearch->indices()->refresh((new Refresh($indexName))->toArray());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTotalCount($results)
    {
        return $results['hits']['total']['value'];
    }
}
