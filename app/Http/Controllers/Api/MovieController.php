<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\MovieResource;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movies = Movie::get();
        return response()->json(['data' => ['movies' => $movies]], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $movie = Movie::where('id', $id)->with('reviews')->withCount('reviews')->first();
        return response()->json(['movie' => MovieResource::make($movie)]);
    }

    /**
     * Search for a resource with a matching attribute
     */
    public function search(Request $request)
    {
        $movies = Movie::with(['reviews'])->where('title', 'LIKE', '%'.$request->input('searchParam').'%')->paginate(25);

        return MovieResource::collection($movies);
    }

    /**
     * Return 5 most recent resources
     */
    public function recent()
    {
        $movies = Movie::with('reviews')->orderBy('created_at', 'desc')->limit(5)->get();
        return response()->json(['movies' => MovieResource::collection($movies)]);
    }
}
