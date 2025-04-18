<!-- Find a car form -->
<section class="find-a-car">
    <div class="container">
        <form
            action="{{ route('car.search') }}"
            method="GET"
            class="find-a-car-form card flex p-medium"
        >
            <div class="find-a-car-inputs">
                <div>
                    <x-select-maker />
                </div>
                <div>
                    <x-select-model />
                </div>
                <div>
                    <x-select-state />
                </div>
                <div>
                    <x-select-city />
                </div>
                <div>
                    <x-select-car-type />
                </div>
                <div>
                    <input type="number" placeholder="Godište od" name="year_from" />
                </div>
                <div>
                    <input type="number" placeholder="Godište do" name="year_to" />
                </div>
                <div>
                    <input
                        type="number"
                        placeholder="Cena od"
                        name="price_from"
                    />
                </div>
                <div>
                    <input type="number" placeholder="Cena do" name="price_to" />
                </div>
                <div>
                    <x-select-fuel-type />
                </div>
            </div>
            <div>
                <button class="btn btn-primary btn-find-a-car-submit">
                    Pretraga
                </button>
            </div>
        </form>
    </div>
</section>
<!--/ Find a car form -->


