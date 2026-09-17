<?php

namespace App\Modules\Movie\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Movie\Services\MovieService;
use Illuminate\Http\Request;

class MovieAdminController extends Controller
{
    public function __construct(protected MovieService $movieService) {}

    public function index()
    {
        $movies = $this->movieService->list();
        return view("movie-module.admin.index", compact("movies"));
    }

    public function create()
    {
        return view("movie-module.admin.form");
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "title"            => "required|string|max:255",
            "description"      => "nullable|string",
            "duration_minutes" => "required|integer|min:1",
            "genre"            => "required|string",
            "age_rating"       => "required|string",
            "status"           => "required|in:coming_soon,now_showing,ended",
        ]);

        $this->movieService->create($data);

        return redirect()->route("admin.movies.index")->with("success", "Them phim thanh cong.");
    }
}
