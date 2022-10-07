<?php

namespace Yousef\SearchEngine\Jobs;

use Elastic\Elasticsearch\Client;
use Illuminate\Support\Collection;
use Yousef\SearchEngine\Searchable\ImportSource;

/**
 * @internal
 */
final class Import
{

    /**
     * @var ImportSource
     */
    private $source;

    /**
     * @param  ImportSource  $source
     */
    public function __construct(ImportSource $source)
    {
        $this->source = $source;
    }

    /**
     * @param  Client  $elasticsearch
     */
    public function handle(Client $elasticsearch): void
    {
        $stages = $this->stages();
        $stages->each(function ($stage) use ($elasticsearch) {
            $stage->handle($elasticsearch);
        });
    }

    private function stages(): Collection
    {
        return ImportStages::fromSource($this->source);
    }
}
