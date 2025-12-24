<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Visitor;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        Visitor::incrementToday();

        $videos = Video::active()->ordered()->get();

        return view('home', compact('videos'));
    }
}
