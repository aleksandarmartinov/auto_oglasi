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

        return view('car-watchlist.index', ['cars' => $cars]);
    }

    public function addOrRemove(Car $car)
    {
        $user = Auth::user();

        // User ne moze dodavati svoj auto u favourite
        if ($car->user_id === $user->id) {
            return response()->json([
                'added' => false,
                'message' => 'Ne mozete dodati vaše automobile u listu omiljenih.'
            ], 403);
        }

        // Provera da li je car pod tim id-em vec favourite
        $carExists = $user->favouriteCars()->where('car_id', $car->id)->exists();

        // Metoda za remove iz favourites
        if ($carExists) {
            $user->favouriteCars()->detach($car);

            return response()->json([
                'added' => false,
                'message' => 'Automobil je uklonjen sa liste omiljenih automobila.'
            ]);
        }

        // Ili da ga dodamo
        $user->favouriteCars()->attach($car);
        return response()->json([
            'added' => true,
            'message' => 'Automobil je dodat u listu omiljenih automobila.'
        ]);
    }
}
