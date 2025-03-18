<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WatchlistController extends Controller
{
    public function index()
    {
        $cars = Auth::user()
            ->favouriteCars() //relacija iz User Modela
            ->with(['primaryImage', 'city', 'carType', 'fuelType', 'maker', 'model'])
            ->paginate(15);

        return view('watchlist.index', ['cars' => $cars]);
    }

    public function storeOrDestroy(Car $car)
    {
        $user = Auth::user();

        // Ako je vec favourite
        $carExists = $user->favouriteCars()->where('car_id', $car->id)->exists();

        // Remove ako postoji
        if ($carExists) {
            $user->favouriteCars()->detach($car);

            return back()->with('success', 'Car was removed from watchlist');
        }

        // Dodaj u watchlist
        $user->favouriteCars()->attach($car);
        return back()->with('success', 'Car was added to watchlist');
    }
}
