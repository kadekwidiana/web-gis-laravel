<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use Illuminate\Http\Request;

class CropController extends Controller
{
    public function index()
    {
        $results = Crop::all();
        return view('maps.map_thailand');
    }

    public function pointCropJson()
    {
        $result = Crop::all();
        return json_encode($result);
    }
}
