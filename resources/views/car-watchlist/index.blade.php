<x-app-layout>
    <main>
        <section>
            <div class="container">
                <div class="flex-justify-between item-center">
                    <h2>Lista praćenih automobila</h2>
                    @if ($cars->total() > 0)
                    <div class="pagination-summary">
                        <p>
                            Prikazano {{ $cars->firstItem() }} do {{ $cars->lastItem() }} od {{ $cars->total() }} rezultata.
                        </p>
                    </div>
                    @endif
                </div>
            <div class="car-item-listing">
                @foreach ($cars as $car)
                        <x-car-item :$car :isInWatchlist="true"/>
                @endforeach
            </div>
                @if($cars->count() === 0)
                    <div class="text-center p-large">
                        Nema rezultata.
                    </div>
                @endif

                {{ $cars->onEachSide(1)->links() }}

            </div>
        </section>
    </main>
</x-app-layout>
