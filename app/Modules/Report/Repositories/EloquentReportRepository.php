<?php

namespace App\Modules\Report\Repositories;

use Illuminate\Support\Facades\DB;

/**
 * NGUOI 5 phu trach - bao cao doanh thu cho Admin.
 */
class EloquentReportRepository implements ReportRepositoryInterface
{
    public function revenueByDateRange(string $from, string $to)
    {
        return DB::table("bookings")
            ->whereBetween("created_at", [$from, $to])
            ->where("status", "confirmed")
            ->selectRaw("DATE(created_at) as date, SUM(total_price) as total")
            ->groupBy("date")
            ->orderBy("date")
            ->get();
    }

    public function topMovies(int $limit = 5)
    {
        return DB::table("bookings")
            ->join("showtimes", "bookings.showtime_id", "=", "showtimes.id")
            ->join("movies", "showtimes.movie_id", "=", "movies.id")
            ->where("bookings.status", "confirmed")
            ->selectRaw("movies.title, COUNT(bookings.id) as total_bookings")
            ->groupBy("movies.title")
            ->orderByDesc("total_bookings")
            ->limit($limit)
            ->get();
    }
}
