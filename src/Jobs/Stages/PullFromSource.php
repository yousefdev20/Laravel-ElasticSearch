<?php

namespace Yousef\SearchEngine\Jobs\Stages;

use Illuminate\Support\Collection;
use Yousef\SearchEngine\Searchable\ImportSource;

/**
 * @internal
 */
final class PullFromSource
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

    public function handle(): void
    {
        $results = $this->source->get()->filter->shouldBeSearchable();
        if (! $results->isEmpty()) {
//            dd($results->first()->searchableUsing());
            $results->first()->searchableUsing()->update($results);
        }
    }

    public function estimate(): int
    {
        return 1;
    }

    public function title(): string
    {
        return 'Indexing...';
    }

    /**
     * @param  ImportSource  $source
     * @return Collection
     */
    public static function chunked(ImportSource $source): Collection
    {
        return $source->chunked()->map(function ($chunk) {
            return new static($chunk);
        });
    }
}
