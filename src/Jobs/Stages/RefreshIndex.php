<?php

namespace Yousef\SearchEngine\Jobs\Stages;

use Elastic\Elasticsearch\Client;
use Yousef\SearchEngine\ElasticSearch\Index;
use Yousef\SearchEngine\ElasticSearch\Params\Indices\Refresh;

/**
 * @internal
 */
final class RefreshIndex
{
    /**
     * @var Index
     */
    private $index;

    /**
     * RefreshIndex constructor.
     *
     * @param  Index  $index
     */
    public function __construct(Index $index)
    {
        $this->index = $index;
    }

    public function handle(Client $elasticsearch): void
    {
        $params = new Refresh($this->index->name());
        $elasticsearch->indices()->refresh($params->toArray());
    }

    public function estimate(): int
    {
        return 1;
    }

    public function title(): string
    {
        return 'Refreshing index';
    }
}