<x-app-layout>
    <main>
        <section>
            <div class="container">
                <div class="flex-justify-between item-center">
                    <h2>My Favourite Cars</h2>
                    @if ($cars->total() > 0)
                    <div class="pagination-summary">
                        <p>
                            Showing {{ $cars->firstItem() }} to {{ $cars->lastItem() }} of {{ $cars->total() }} results.
                        </p>
                    </div>
                    @endif
                </div>
            <div class="car-item-listing">
                @foreach ($cars as $car)
                        <x-car-item :$car :isInWatchlist="true"/>
                @endforeach
            </div>
                {{ $cars->onEachSide(1)->links() }}
            </div>
        </section>
    </main>
</x-app-layout>
