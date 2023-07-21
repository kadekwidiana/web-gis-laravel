<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Models\Point;
use Illuminate\Http\Request;

class PointController extends Controller
{
    public function index()
    {
        $result = Lokasi::all();

        return view('home', compact('result'));
    }

    public function pointJson()
    {
        $result = Point::all();
        return json_encode($result);
    }

    public function locationJson($id)
    {
        $result = Lokasi::findOrFail($id);
        return json_encode($result);
    }
}
