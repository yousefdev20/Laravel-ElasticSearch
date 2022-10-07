<?php

namespace Yousef\SearchEngine\ElasticSearch;

interface Alias
{
    public function name(): string;

    public function config(): array;
}
