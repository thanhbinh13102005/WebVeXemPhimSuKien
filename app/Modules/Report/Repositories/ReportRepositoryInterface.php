<?php

namespace App\Modules\Report\Repositories;

interface ReportRepositoryInterface
{
    public function revenueByDateRange(string $from, string $to);
    public function topMovies(int $limit = 5);
}
