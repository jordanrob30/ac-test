<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\MovieCSVUploadJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;

class MoviesController extends Controller
{
    public function index()
    {
        return view('admin.movies.index');
    }

    public function import(Request $request)
    {
       

            $csv = fopen(public_path('/uploads/movies-trimmed.csv'),'r');
            $csv = fgetcsv($csv);
            $chunks = array_chunk($csv, 1000);
            $header = [];
            $batch = Bus::batch([])->dispatch();

            foreach($chunks as $key => $chunk) {
                $data = array_map('str_getcsv', $chunk);
                if($key === 0) {
                    $header = $data[0];
                    unset($data[0]);
                }
                $batch->add(new MovieCSVUploadJob($data, $header));
            }
            return $batch;
        
        
    }

}
