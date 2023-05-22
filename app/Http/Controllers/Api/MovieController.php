<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\MovieResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;

class MovieController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return MovieResource::collection(Movie::with(['reviews'])->paginate(5));
    }

    /**
     * @param string $id
     *
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $movie = Movie::where('id', $id)->with('reviews')->withCount('reviews')->first();

        return response()->json(['movie' => MovieResource::make($movie)]);
    }

    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     */
    public function search(Request $request): AnonymousResourceCollection
    {
        $movies = Movie::with(['reviews'])->where('title', 'LIKE', '%'.$request->input('searchParam').'%')
            ->paginate(5);

        return MovieResource::collection($movies);
    }

    /**
     * @return JsonResponse
     */
    public function recent(): JsonResponse
    {
        $movies = Movie::with('reviews')->orderBy('created_at', 'desc')->limit(5)->get();

        return response()->json(['movies' => MovieResource::collection($movies)]);
    }
}
