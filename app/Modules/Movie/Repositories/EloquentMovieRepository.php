<?php

namespace App\Modules\Movie\Repositories;

use App\Modules\Movie\Models\Movie;

/**
 * NGUOI 2 phu trach.
 * Doi sang NoSQL: chi sua class nay, MovieService/Controller giu nguyen.
 */
class EloquentMovieRepository implements MovieRepositoryInterface
{
    public function all(array $filters = [])
    {
        $query = Movie::query();

        if (!empty($filters["genre"])) {
            $query->where("genre", $filters["genre"]);
        }
        if (!empty($filters["status"])) {
            $query->where("status", $filters["status"]);
        }
        if (!empty($filters["keyword"])) {
            $query->where("title", "like", "%" . $filters["keyword"] . "%");
        }

        return $query->paginate(12);
    }

    public function find(int $id)
    {
        return Movie::with("showtimes")->findOrFail($id);
    }

    public function create(array $data)
    {
        return Movie::create($data);
    }

    public function update(int $id, array $data)
    {
        $movie = Movie::findOrFail($id);
        $movie->update($data);
        return $movie;
    }

    public function delete(int $id)
    {
        return Movie::destroy($id);
    }
}
