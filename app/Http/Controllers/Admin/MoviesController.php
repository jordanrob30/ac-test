<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadMoviesRequest;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;

class MoviesController extends Controller
{
    /**
     * @param UploadMoviesRequest $request
     *
     * @return JsonResponse
     */
    public function upload(UploadMoviesRequest $request): JsonResponse
    {
        $file = $request->file('file');
        $handle = fopen($file->getRealPath(), 'r');
        $header = fgetcsv($handle);

        while (!feof($handle)) {
            $rows = [];
            for ($i = 0; $i < 1000; $i++) { //Was running into memory issues so lets chunk it by 1000 at a time
                $row = fgetcsv($handle);
                if ($row !== false) {
                    $rows[] = $row;
                } else {
                    break;
                }
            }

            $chunkMovies = [];
            foreach ($rows as $row) {
                $chunkMovies[] = array_combine($header, $row);
            }

            foreach ($chunkMovies as $movieData) {
                Movie::create([
                    'title'        => $movieData['title'],
                    'overview'     => $movieData['overview'],
                    'release_date' => $movieData['release_date'],
                    'tagline'      => $movieData['tagline'],
                ]);
            }
        }

        fclose($handle);

        return response()->json(['message' => 'Upload Successful']);
    }
}
