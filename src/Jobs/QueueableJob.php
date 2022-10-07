<?php

namespace Yousef\SearchEngine\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Yousef\SearchEngine\ProgressReportable;

class QueueableJob implements ShouldQueue
{
    use Queueable;
    use ProgressReportable;

    public function handle(): void
    {
    }
}
