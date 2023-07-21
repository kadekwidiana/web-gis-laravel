<?php

namespace App\Http\Controllers;

use App\Models\Map;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function viewMap()
    {
        // $dataMaps = Map::all();
        return view('maps.map');
    }
}
