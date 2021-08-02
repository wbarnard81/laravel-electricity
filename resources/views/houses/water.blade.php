@include('includes.header')
@include('components.navbar')
    <section class="p-sm-5 container-fluid">
        <div class="d-sm-flex justify-content-center">
            <div>
                <h2 class="text-center p-4 m-0">{{ $house->name }}</h2>
                <div>
                    <a href="/houses/{{ $house->id }}/electricity" class="btn btn-sm btn-warning">Electricity Readings</a>
                </div>
            </div>
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
                    Water Usage for {{$house->name}}
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-sm-3">
                            <form action="/houses/{{$house->id}}/meters/{{$house->meters[1]->id}}/readings/start_reading" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input type="text" name="start_reading" 
                                    class="form-control @error('start_reading') {{'is-invalid'}} @enderror" 
                                    {{ count($months) > 0 ? 'readonly' : '' }}
                                    placeholder="Start Reading" aria-label="Start Reading" aria-describedby="button-addon2" value="{{ old('start_reading') }}">
                                    <button class="btn btn-outline-dark @if (count($months) > 0) {{'disabled'}} @endif" type="submit">Add</button>
                                </div>
                                @error('start_reading')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror 
                            </form>
                        </div>
                        <div class="col-sm-6 mx-sm-2">
                            <form action="/houses/{{$house->id}}/meters/{{$house->meters[1]->id}}/readings/units_purchased" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input type="text" name="units_purchased" 
                                    class="form-control @error('units_purchased') {{'is-invalid'}} @enderror"
                                    {{ count($months) == 0 ? 'readonly' : '' }} 
                                    placeholder="Units Purchased" aria-label="Units Purchased" aria-describedby="button-addon2" value="{{ old('units_purchased') }}">
                                    
                                    <input type="text" name="rand_value" class="form-control @error('rand_value') {{'is-invalid'}} @enderror" 
                                    {{ count($months) == 0 ? 'readonly' : '' }}
                                    placeholder="Rand Value" aria-label="Rand Value" aria-describedby="button-addon2" value="{{ old('rand_value') }}">
                                    <button class="btn btn-outline-dark @if (count($months) == 0) {{'disabled'}} @endif" type="submit">Add</button>
                                </div>
                                @error('units_purchased')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                                @error('rand_value')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            </form>
                        </div>
                        <div class="col-sm-3">
                            <form action="/houses/{{$house->id}}/meters/{{$house->meters[1]->id}}/readings/reading" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input type="text" name="reading" 
                                    class="form-control @error('reading') {{'is-invalid'}} @enderror"
                                    {{ count($months) == 0 ? 'readonly' : '' }}
                                    placeholder="Meter Reading" aria-label="Meter Reading" aria-describedby="button-addon2" value="{{ old('reading') }}">
                                    <button class="btn btn-outline-dark @if (count($months) == 0) {{'disabled'}} @endif" type="submit">Add</button>
                                </div>
                                @error('reading')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            </form>
                        </div>
                    </div>

                    <div class="row g-2 mt-2">
                        <div class="col">
                            <ul class="nav justify-content-center border">
                            @forelse ($years as $year)
                                <li class="nav-item">
                                    <a class="btn btn-sm btn-outline-secondary" aria-current="page" href="/houses/{{$house->id}}/{{$house->meters[1]->type}}?year={{$year}}">{{ $year }}</a>
                                </li>
                            @empty
                                <li></li>
                            @endforelse
                            </ul>
                        </div>
                        <div class="col">
                            <ul class="nav justify-content-center border">
                            @forelse ($months as $month)
                                <li class="nav-item">
                                    <a class="btn btn-sm btn-outline-secondary" aria-current="page" href="/houses/{{$house->id}}/{{$house->meters[1]->type}}?month={{$month}}">{{ $month }}</a>
                                </li>
                            @empty
                                <li></li>
                            @endforelse
                            </ul>
                        </div>
                    </div>

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm p-0" style="position: relative;">
                                <canvas id="canvas"></canvas>
                            </div>
                            <div class="col-sm p-0 table-responsive-sm">
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
                                            @if ($meter->type == "water")
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
            </div>
    </section>
@include('includes.footer')

@include('includes.canvas')