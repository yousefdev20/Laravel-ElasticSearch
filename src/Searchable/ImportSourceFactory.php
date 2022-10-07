<?php

namespace Yousef\SearchEngine\Searchable;

interface ImportSourceFactory
{
    public static function from(string $className): ImportSource;
}
