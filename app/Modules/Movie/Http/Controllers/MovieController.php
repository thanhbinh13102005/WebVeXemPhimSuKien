<?php

namespace App\Modules\Movie\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Movie\Services\MovieService;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function __construct(protected MovieService $movieService) {}

    public function index(Request $request)
    {
        $movies = $this->movieService->list($request->only(["genre", "status", "keyword"]));
        return view("movie-module.index", compact("movies"));
    }

    public function show(int $id)
    {
        $movie = $this->movieService->detail($id);
        return view("movie-module.show", compact("movie"));
    }
}
