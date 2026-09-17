<?php

namespace App\Modules\Movie\Services;

use App\Modules\Movie\Repositories\MovieRepositoryInterface;
use Illuminate\Validation\ValidationException;

class MovieService
{
    // Rang buoc: khoang cach toi thieu (phut) giua 2 lan them phim, tranh spam
    const MIN_MINUTES_BETWEEN_ADD = 2;

    public function __construct(protected MovieRepositoryInterface $movieRepo) {}

    public function list(array $filters = [])
    {
        return $this->movieRepo->all($filters);
    }

    public function detail(int $id)
    {
        return $this->movieRepo->find($id);
    }

    public function create(array $data)
    {
        $this->assertNotSpamming();
        return $this->movieRepo->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->movieRepo->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->movieRepo->delete($id);
    }

    // TODO NGUOI 2: doi cache() sang bang log that neu can luu vet ai them luc nao
    protected function assertNotSpamming(): void
    {
        $lastAdded = cache()->get("last_movie_added_at");
        if ($lastAdded && now()->diffInMinutes($lastAdded) < self::MIN_MINUTES_BETWEEN_ADD) {
            throw ValidationException::withMessages([
                "title" => "Vui long doi it nhat " . self::MIN_MINUTES_BETWEEN_ADD . " phut truoc khi them phim tiep theo.",
            ]);
        }
        cache()->put("last_movie_added_at", now(), now()->addMinutes(10));
    }
}
