@props(['car' => null])

@php
    $features = [
        'air_conditioning' => 'Klima',
        'power_windows' => 'Električni podizači',
        'power_door_locks' => 'Power Door Locks',
        'abs' => 'ABS',
        'cruise_control' => 'Cruise Control',
        'bluetooth_connectivity' => 'Bluetooth Connectivity',
        'remote_start' => 'Remote Start',
        'gps_navigation' => 'GPS Navigation System',
        'seat_heaters' => 'Seat Heaters',
        'climate_control' => 'Climate Control',
        'rear_parking_sensors' => 'Rear Parking Sensors',
        'leather_seats' => 'Leather Seats',
    ];
@endphp

<div class="form-group">
    <div class="row">
        <div class="col">
            @foreach($features as $key => $feature)
                <label class="checkbox">
                    <input
                        type="checkbox"
                        name="features[{{ $key }}]"
                        value="1"
                        @checked(old('features.'.$key, $car?->features->$key))
                    />
                    {{ $feature }}
                </label>
                @if ($loop->iteration % 6 == 0 && !$loop->last)
        </div>
        <div class="col">
            {{--delim na 6 da bi se pojavile dve kolone, zatvara se jedna a otvara druga--}}
            @endif
            @endforeach
        </div>
    </div>
</div>
