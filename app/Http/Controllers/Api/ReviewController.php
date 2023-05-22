<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpsertReviewRequest;
use App\Http\Resources\ReviewResource;
use Illuminate\Http\Request;

use App\Models\Review;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * @param UpsertReviewRequest $request
     *
     * @return ReviewResource
     */
    public function store(UpsertReviewRequest $request): ReviewResource
    {
        return ReviewResource::make(Review::create($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function recent(): AnonymousResourceCollection
    {
        $reviews = Review::with('movie', 'movie.reviews')->orderBy('created_at', 'desc')->limit(5)->get();
        return ReviewResource::collection($reviews);
    }
}
