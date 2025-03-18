<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $cars = Cache::remember('home-cars', 30, function() {
            return Car::where('published_at', '<', now())
                ->with(['primaryImage', 'city', 'carType', 'fuelType',
                    'maker', 'model', 'favouredUsers'])
                ->orderBy('published_at', 'desc')
                ->limit(30)
                ->get();
        });

        return view('home.index', ['cars' => $cars]);
    }
}
