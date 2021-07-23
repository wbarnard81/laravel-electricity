<x-app-layout>
    <x-slot name="header">
    <h2 class="text-center p-4 m-0">Dashboard</h2>
    
    @if (session('successMsg'))
        <div class="alert alert-success text-center">
            {{ session('successMsg') }}
        </div>
    @endif
        
    </x-slot>

    <div class="p-4 text-center">
        <p>Your houses will be displayed here...</p>
        <div>
            <a href="/houses/create" class="btn btn-dark">Add a House</a>
        </div>
    </div>

    <div class="container">
        <div class="row mb-4">
            @if ($houses)
                <div class="d-flex justify-content-around flex-wrap">
                    @foreach ($houses as $house)
                        <div class="col-3 m-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $house->name }}</h5>
                                    <p class="card-text">{{ $house->complex ?? '' }}</p>
                                    <p class="card-text">{{ $house->address }}</p>
                                    <p class="card-text">{{ $house->city }}</p>
                                    <p class="card-text">{{ $house->province }}</p>
                                    <p class="card-text">{{ $house->postal_code }}</p>
                                </div>
                                <div class="card-footer d-flex justify-content-between">
                                    <a href="/houses/{{ $house->id }}/water" class="btn btn-sm btn-primary">Water Readings</a>
                                    <a href="/houses/{{ $house->id }}/electricity" class="btn btn-sm btn-warning">Electricity Readings</a>
                                </div>
                            </div>
                        </div>                    
                    @endforeach
                </div>
            @else
                <div>No houses to display. Start by adding a bouse.</div>
            @endif
        </div>
    </div>
</x-app-layout>
