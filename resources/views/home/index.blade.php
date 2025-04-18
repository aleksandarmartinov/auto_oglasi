<x-app-layout title="Home Page">
    <!-- Home Slider -->
    <section class="hero-slider">
        <div class="hero-slides">
            <!-- Item 1 -->
            <div class="hero-slide">
                <div class="container">
                    <div class="slide-content">
                        <h1 class="hero-slider-title">
                            Kupi <strong>Najbolji Automobil</strong> <br />
                            u tvojoj blizini!
                        </h1>
                        <div class="hero-slider-content">
                            <p>
                                Ovaj sajt će Vam pomoći da pronadjete idealan automobil na osnovu kriterijuma kao što su : Proizvodjač, Marka automobila, Regija itd...
                            </p>

                            <a href="{{ route('car.search') }}" class="btn btn-hero-slider">Pretražite Oglase</a>
                        </div>
                    </div>
                    <div class="slide-image">
                        <img src="{{ asset('img/blue-car.png') }}" alt="Car Image" class="img-responsive" />
                    </div>
                </div>
            </div>
            <!-- Item 2 -->
            <div class="hero-slide">
                <div class="flex container">
                    <div class="slide-content">
                        <h2 class="hero-slider-title">
                            Da li možda<br />
                            <strong>prodajete automobil?</strong>
                        </h2>
                        <div class="hero-slider-content">
                            <p>
                                Ovaj sajt je idealno mesto da postavite oglas za vaš automobil i kupac će vas ubrzo pronaći!
                            </p>

                            <a href="{{ route('car.create') }}" class="btn btn-hero-slider">Postavite Oglas</a>
                        </div>
                    </div>
                    <div class="slide-image">
                        <img src="{{ asset('img/blue-car.png') }}" alt="Car Image" class="img-responsive" />
                    </div>
                </div>
            </div>
            <button type="button" class="hero-slide-prev">
                <svg
                    style="width: 18px"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 6 10"
                >
                    <path
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M5 1 1 5l4 4"
                    />
                </svg>
                <span class="sr-only">Previous</span>
            </button>
            <button type="button" class="hero-slide-next">
                <svg
                    style="width: 18px"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 6 10"
                >
                    <path
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="m1 9 4-4-4-4"
                    />
                </svg>
                <span class="sr-only">Next</span>
            </button>
        </div>
    </section>
    <!--/ Home Slider -->

    <main>

        <x-search-form />

        <!-- New Cars -->
        <section>
            <div class="container">
                <h2>Poslednje dodati automobili</h2>
                @if($cars->count() > 0 )
                <div class="car-items-listing">
                    @foreach($cars as $car)
                        <x-car-item :$car :is-in-watchlist="$car->favouredUsers->contains(Auth::user())"/>
                    @endforeach
                </div>
                @else
                    <div class="text-center p-large">
                        Ne postoje još objavljeni automobili.
                    </div>
                @endif
            </div>
        </section>
        <!--/ New Cars -->
    </main>
</x-app-layout>


