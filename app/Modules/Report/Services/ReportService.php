<?php

namespace App\Modules\Report\Services;

use App\Modules\Report\Repositories\ReportRepositoryInterface;

class ReportService
{
    public function __construct(protected ReportRepositoryInterface $reportRepo) {}

    public function revenue(string $from, string $to)
    {
        return $this->reportRepo->revenueByDateRange($from, $to);
    }

    public function topMovies()
    {
        return $this->reportRepo->topMovies();
    }
}
