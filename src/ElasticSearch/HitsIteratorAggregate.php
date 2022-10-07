<?php

namespace Yousef\SearchEngine\ElasticSearch;

interface HitsIteratorAggregate extends \IteratorAggregate
{
    public function __construct(array $results, callable $callback = null);

    public function getIterator();
}
