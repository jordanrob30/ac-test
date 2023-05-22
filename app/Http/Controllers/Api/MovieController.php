<?php

namespace App\Http\Controllers\Api;

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
        return response()->json(['movie' => $movie], 200);
    }

    /**
     * Search for a resource with a matching attribute
     */
    public function search(Request $request)
    {
        $searchQuery = "SELECT * FROM movies WHERE movies.title LIKE '%" . $request->input('searchParam') . "%' LIMIT 100;";

        $results = DB::select($searchQuery);
        return $results;
    }

    /**
     * Return 5 most recent resources
     */
    public function recent()
    {
        $movies = Movie::orderBy('created_at', 'desc')->limit(5)->get();
        return response()->json(['movies' => $movies], 200);
    }
}
