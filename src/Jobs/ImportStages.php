<?php

namespace Yousef\SearchEngine\Jobs;

use Illuminate\Support\Collection;
use Yousef\SearchEngine\ElasticSearch\Index;
use Yousef\SearchEngine\Jobs\Stages\CleanUp;
use Yousef\SearchEngine\Jobs\Stages\CreateWriteIndex;
use Yousef\SearchEngine\Jobs\Stages\PullFromSource;
use Yousef\SearchEngine\Jobs\Stages\RefreshIndex;
use Yousef\SearchEngine\Jobs\Stages\SwitchToNewAndRemoveOldIndex;
use Yousef\SearchEngine\Searchable\ImportSource;

class ImportStages extends Collection
{
    /**
     * @param  ImportSource  $source
     * @return Collection
     */
    public static function fromSource(ImportSource $source)
    {
        $index = Index::fromSource($source);

        return (new self([
            new CleanUp($source),
            new CreateWriteIndex($source, $index),
            PullFromSource::chunked($source),
            new RefreshIndex($index),
            new SwitchToNewAndRemoveOldIndex($source, $index),
        ]))->flatten()->filter();
    }
}
