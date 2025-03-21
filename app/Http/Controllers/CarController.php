<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarRequest;
use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $cars = $request->user()
            ->cars()
            ->with(['primaryImage', 'maker', 'model'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('car.index', ['cars' => $cars]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('car.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCarRequest $request)
    {
        // Get request data and validate
        $data = $request->validated();
        // Get features
        $featuresData = $data['features'];
        // Get images
        $images = $request->file('images') ?: [];

        // Set user ID
        $data['user_id'] = Auth::id();
        // Create new car
        $car = Car::create($data);

        // Create features
        $car->features()->create($featuresData); //featuresData odozgore

        // Iterate and create images
        foreach ($images as $i => $image) {
            // Save image on file system
            $path = $image->store('images', 'public');
            // Create record in the database
            $car->images()->create(['image_path' => $path, 'position' => $i + 1]);
        }

        return redirect()->route('car.index')
            ->with('success', 'Car was created');
    }

    public function show(Request $request,Car $car)
    {
        if (!$car->published_at) {
            abort(404);
        }

        return view('car.show', ['car' => $car]);
    }

    public function edit(Car $car)
    {
        Gate::authorize('update', $car);

        return view('car.edit', ['car' => $car]);
    }

    public function update(StoreCarRequest $request, Car $car)
    {
        Gate::authorize('update', $car);

        // validacija iz request-a
        $data = $request->validated();

        // car features
        $features = array_merge([
            'abs' => 0,
            'air_conditioning' => 0,
            'power_windows' => 0,
            'power_door_locks' => 0,
            'cruise_control' => 0,
            'bluetooth_connectivity' => 0,
            'remote_start' => 0,
            'gps_navigation' => 0,
            'seat_heaters' => 0,
            'climate_control' => 0,
            'rear_parking_sensors' => 0,
            'leather_seats' => 0,
        ], $data['features'] ?? []); //prilikom editovanja svi features ce biti 0 da bi ponistili stare pa tek onda uzimamo nove

        // update car data
        $car->update($data);

        // update car features
        $car->features()->update($features); //features je metoda a ne property

        return redirect()->route('car.index')
            ->with('success', 'Car was updated');
    }

    public function destroy(Car $car)
    {
        Gate::authorize('delete', $car);

        $car->delete();

        return redirect()->route('car.index')
            ->with('success', 'Car was deleted');
    }

    public function search(Request $request)
    {
        $maker = $request->integer('maker_id');
        $model = $request->integer('model_id');
        $carType = $request->integer('car_type_id');
        $fuelType = $request->integer('fuel_type_id');
        $state = $request->integer('state_id');
        $city = $request->integer('city_id');
        $yearFrom = $request->integer('year_from');
        $yearTo = $request->integer('year_to');
        $priceFrom = $request->integer('price_from');
        $priceTo = $request->integer('price_to');
        $mileage = $request->integer('mileage');
        $sort = $request->input('sort', '-published_at');

        $query = Car::where('published_at', '<', now())
            ->with(['primaryImage', 'city', 'carType', 'fuelType', 'maker', 'model', 'favouredUsers'])
        ;

        if ($maker) {
            $query->where('maker_id', $maker);
        }
        if ($model) {
            $query->where('model_id', $model);
        }
        if ($state) {
            $query->join('cities', 'cities.id', '=', 'cars.city_id')
                ->where('cities.state_id', $state); //join gde cities id iz tabele cities je jednak city id iz tabele auto
        }
        if ($city) {
            $query->where('city_id', $city);
        }
        if ($carType) {
            $query->where('car_type_id', $carType);
        }
        if ($fuelType) {
            $query->where('fuel_type_id', $fuelType);
        }
        if ($yearFrom) {
            $query->where('year', '>=', $yearFrom);
        }
        if ($yearTo) {
            $query->where('year', '<=', $yearTo);
        }
        if ($priceFrom) {
            $query->where('price', '>=', $priceFrom);
        }
        if ($priceTo) {
            $query->where('price', '<=', $priceTo);
        }
        if ($mileage) {
            $query->where('mileage', '<=', $mileage);
        }

        //ako je descending
        if (str_starts_with($sort, '-')) {
            $sort = substr($sort, 1); //sub-string
            $query->orderBy($sort, 'desc');
            //ako ne
        } else {
            $query->orderBy($sort);
        }

        $cars = $query->paginate(15)
            ->withQueryString(); //ostaju parametri iz search-a u stringu

        return view('car.search', ['cars' => $cars]);
    }

    public function carImages(Car $car)
    {
        Gate::authorize('update', $car);

        return view('car.images', ['car' => $car]);
    }

    public function updateImages(Request $request, Car $car)
    {
        Gate::authorize('update', $car);

        // validacija slika i pozicija slika
        $data = $request->validate([
            'delete_images' => 'array',
            'delete_images.*' => 'integer',
            'positions' => 'array',
            'positions.*' => 'integer',
        ]);

        //ako validacija prodje
        $deleteImages = $data['delete_images'] ?? [];
        $positions = $data['positions'] ?? [];

        // setovanje slike za brisanje
        $imagesToDelete = $car->images()->whereIn('id', $deleteImages)->get();

        // brisanje slika iz Storage/file sistema
        foreach ($imagesToDelete as $image) {
            if (Storage::exists($image->image_path)) {
                Storage::delete($image->image_path);
            }
        }

        // krajnje brisanje slika iz baze podataka
        $car->images()->whereIn('id', $deleteImages)->delete();

        // loop kroz pozicije slika i update pozicije na osnovu ID
        foreach ($positions as $id => $position) {
            $car->images()->where('id', $id)->update(['position' => $position]);
        }

        return redirect()->back()
            ->with('success', 'Car images were updated');
    }

    public function addImages(Request $request, Car $car)
    {
        Gate::authorize('update', $car);

        // slika iz request-a
        $images = $request->file('images') ?? [];

        // krajnja pozicija slika da bi dodata slika krenula od sledece pozicije
        $position = $car->images()->max('position') ?? 0; //ako ni jedna pozicija ne postoji, pozicija ce biti 0
        foreach ($images as $image) {
            // save u file sistem
            $path = $image->store('images', 'public');
            // save u database
            $car->images()->create([
                'image_path' => $path,
                'position' => $position + 1
            ]);
            $position++;
        }

        return redirect()->back()
            ->with('success', 'New images were added');
    }
}
