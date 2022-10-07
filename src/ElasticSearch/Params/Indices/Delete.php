<?php

namespace Yousef\SearchEngine\ElasticSearch\Params\Indices;

/**
 * @internal
 */
final class Delete
{
    /**
     * @var string
     */
    private $index;

    /**
     * Delete constructor.
     *
     * @param  string  $index
     */
    public function __construct(string $index)
    {
        $this->index = $index;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'index' => $this->index,
        ];
    }
}
