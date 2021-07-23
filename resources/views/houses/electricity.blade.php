@include('includes.header')
@include('components.navbar')
    <section class="p-5">
        <div class="d-flex justify-content-center">
            <h2 class="text-center p-4 m-0">{{ $house->name }}</h2>
            <div class="flex-column">
                <div>
                    <small>{{ $house->complex }}</small>
                </div>
                <div>
                    <small>{{ $house->address }}</small>
                </div>
                <div>
                    <small>{{ $house->city }}</small>
                </div>
                <div>
                    <small>{{ $house->province }}</small>
                </div>
                <div>
                    <small>{{ $house->postal_code }}</small>
                </div>
            </div>
        </div>
        @if (session('successMsg'))
            <div class="alert alert-success text-center">
                {{ session('successMsg') }}
            </div>
        @endif

            <div class="card mt-4">
                <div class="card-header text-center">
                    Electricity Usage for {{$house->name}}. Total purchased amout: R {{ $house->electricityValue($house->meters[0]->id) }}
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-3">
                            <form action="/houses/{{$house->id}}/meters/{{$house->meters[0]->id}}/readings/start_reading" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input type="text" name="start_reading" 
                                    class="form-control @error('start_reading') {{'is-invalid'}} @enderror" 
                                    {{ $house->meters[0]->readings->count() > 0 ? 'readonly' : '' }}
                                    placeholder="Start Reading" aria-label="Start Reading" aria-describedby="button-addon2" value="{{ old('start_reading') }}">
                                    <button class="btn btn-outline-dark @if ($house->meters[0]->readings->count() > 0) {{'disabled'}} @endif" type="submit">Add</button>
                                </div>
                                @error('start_reading')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror 
                            </form>
                        </div>
                        <div class="col-6">
                            <form action="/houses/{{$house->id}}/meters/{{$house->meters[0]->id}}/readings/units_purchased" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input type="text" name="units_purchased" 
                                    class="form-control @error('units_purchased') {{'is-invalid'}} @enderror" 
                                    placeholder="Units Purchased" aria-label="Units Purchased" aria-describedby="button-addon2" value="{{ old('units_purchased') }}">
                                    
                                    <input type="text" name="rand_value" class="form-control @error('rand_value') {{'is-invalid'}} @enderror" placeholder="Rand Value" aria-label="Rand Value" aria-describedby="button-addon2" value="{{ old('rand_value') }}">
                                    <button class="btn btn-outline-dark" type="submit">Add</button>
                                </div>
                                @error('units_purchased')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                                @error('rand_value')
                                <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            </form>
                        </div>
                        <div class="col-3">
                            <form action="/houses/{{$house->id}}/meters/{{$house->meters[0]->id}}/readings/reading" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input type="text" name="reading" 
                                    class="form-control @error('reading') {{'is-invalid'}} @enderror" 
                                    placeholder="Meter Reading" aria-label="Meter Reading" aria-describedby="button-addon2" value="{{ old('reading') }}">
                                    <button class="btn btn-outline-dark" type="submit">Add</button>
                                </div>
                                @error('reading')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            </form>
                        </div>
                    </div>

                    <div class="row my-2">
                        <div class="col">
                            @include('includes.year-bar', ['years' => $years])
                        </div>
                        <div class="col">
                            @include('includes.month-bar', ['months' => $months])
                        </div>
                    </div>

                    <div class="row align-items-start">
                        <div class="col">
                            <canvas id="canvas"></canvas>
                        </div>
                        <div class="col">
                            <table id="meterTable" class="table is-striped is-bordered">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Previous Reading</th>
                                        <th>Today's Reading</th>
                                        <th>Units Used</th>
                                        <th>Units Purchased</th>
                                    </tr>
                                </thead>
                                <tbody id="meterTableBody">
                                    @foreach ($house->meters as $meter)
                                        @if ($meter->type == "electricity")
                                            @forelse ($meter->readings as $reading)
                                                <tr>
                                                    <td>{{ date("Y/m/d", strtotime($reading['created_at'])) }}</td>
                                                    <td>{{ $reading['previous_reading'] }}</td>
                                                    <td>{{ $reading['reading'] }}</td>
                                                    <td>{{ $reading['units_used'] }}</td>
                                                    <td>{{ $reading['units_purchased'] }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5">No data to show.</td>
                                                </tr>
                                            @endforelse
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@include('includes.footer')

@include('includes.canvas')