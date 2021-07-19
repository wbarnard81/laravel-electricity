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

        <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link fs-4 active" id="electricity-tab" data-bs-toggle="tab" data-bs-target="#electricity" type="button" role="tab" aria-controls="electricity" aria-selected="true">Electricity</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fs-4" id="water-tab" data-bs-toggle="tab" data-bs-target="#water" type="button" role="tab" aria-controls="water" aria-selected="false">Water</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="electricity" role="tabpanel" aria-labelledby="electricity-tab">
                <div class="card">
                    <div class="card-header text-center">
                        Electricity Usage for {{$house->name}}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <form action="/houses/{{$house->id}}/meters/{{$house->meters[0]->id}}/readings/start_reading" method="POST">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <input type="text" name="start_reading" 
                                        class="form-control @error('start_reading') {{'is-invalid'}} @enderror" 
                                        placeholder="Start Reading" aria-label="Start Reading" aria-describedby="button-addon2" value="{{ old('start_reading') }}">
                                        @error('start_reading')
                                            <div class="">{{ $message }}</div>
                                        @enderror 
                                        <button class="btn btn-outline-dark" type="submit">Add</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-6">
                                <form action="/houses/{{$house->id}}/meters/{{$house->meters[0]->id}}/readings/units_purchased" method="POST">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <input type="text" name="units_purchased" 
                                        class="form-control @error('units_purchased') {{'is-invalid'}} @enderror" 
                                        placeholder="Units Purchased" aria-label="Units Purchased" aria-describedby="button-addon2" value="{{ old('units_purchased') }}">
                                        @error('units_purchased')
                                            <div class="">{{ $message }}</div>
                                        @enderror
                                        
                                        <input type="text" name="rand_value" class="form-control @error('rand_value') {{'is-invalid'}} @enderror" placeholder="Rand Value" aria-label="Rand Value" aria-describedby="button-addon2" value="{{ old('rand_value') }}">
                                        @error('rand_value')
                                            <div class="">{{ $message }}</div>
                                        @enderror
                                        <button class="btn btn-outline-dark" type="submit">Add</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-3">
                                <form action="/houses/{{$house->id}}/meters/{{$house->meters[0]->id}}/readings/reading" method="POST">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <input type="text" name="reading" 
                                        class="form-control @error('reading') {{'is-invalid'}} @enderror" 
                                        placeholder="Meter Reading" aria-label="Meter Reading" aria-describedby="button-addon2" value="{{ old('reading') }}">
                                        @error('reading')
                                            <div class="">{{ $message }}</div>
                                        @enderror
                                        <button class="btn btn-outline-dark" type="submit">Add</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row align-items-start">
                            <div class="col">
                                <canvas id="electricityCanvas"></canvas>
                            </div>
                            <div class="col">
                                <table id="meterTable" class="table is-striped is-bordered">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Previous Meter Reading</th>
                                            <th>Meter Reading</th>
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
                                                        <td>{{ intval($reading['previous_reading']) - intval($reading['reading']) }}</td>
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
            <div class="tab-pane fade" id="water" role="tabpanel" aria-labelledby="water-tab">
                <div class="card">
                    <div class="card-header text-center">
                        Water Usage for {{$house->name}}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <form action="/meter/reading/" method="POST">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <input type="text" name="start_reading" 
                                        class="form-control @error('start_reading') {{'is-invalid'}} @enderror" 
                                        placeholder="Start Reading" aria-label="Start Reading" aria-describedby="button-addon2" value="{{ old('start_reading') }}">
                                        @error('start_reading')
                                            <div class="">{{ $message }}</div>
                                        @enderror 
                                        <button class="btn btn-outline-dark" type="submit">Add</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-6">
                                <form action="/meter/reading/" method="POST">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <input type="text" name="units_purchased" 
                                        class="form-control @error('units_purchased') {{'is-invalid'}} @enderror" 
                                        placeholder="Units Purchased" aria-label="Units Purchased" aria-describedby="button-addon2" value="{{ old('units_purchased') }}">
                                        @error('units_purchased')
                                            <div class="">{{ $message }}</div>
                                        @enderror
                                        
                                        <input type="text" name="rand_value" class="form-control @error('rand_value') {{'is-invalid'}} @enderror" placeholder="Rand Value" aria-label="Rand Value" aria-describedby="button-addon2" value="{{ old('rand_value') }}">
                                        @error('rand_value')
                                            <div class="">{{ $message }}</div>
                                        @enderror
                                        <button class="btn btn-outline-dark" type="submit">Add</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-3">
                                <form action="/meter/reading/" method="POST">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <input type="text" name="reading" 
                                        class="form-control @error('reading') {{'is-invalid'}} @enderror" 
                                        placeholder="Meter Reading" aria-label="Meter Reading" aria-describedby="button-addon2" value="{{ old('reading') }}">
                                        @error('reading')
                                            <div class="">{{ $message }}</div>
                                        @enderror
                                        <button class="btn btn-outline-dark" type="submit">Add</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row align-items-start">
                            <div class="col">
                                <canvas id="waterCanvas"></canvas>
                            </div>
                            <div class="col">
                                <table id="meterTable" class="table is-striped is-bordered">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Previous Meter Reading</th>
                                            <th>DB Meter Reading</th>
                                            <th>Units Used</th>
                                            <th>Units Purchased</th>
                                        </tr>
                                    </thead>
                                    <tbody id="meterTableBody">
                                        @foreach ([] as $reading)
                                            <tr>
                                                <td>{{ date("Y/m/d", strtotime($reading['created_at'])) }}</td>
                                                <td>{{ $reading['previous_reading'] }}</td>
                                                <td>{{ $reading['reading'] }}</td>
                                                <td>{{ intval($reading['previous_meter_reading']) - intval($reading['meter_reading']) - intval($reading['units_purchased']) }}</td>
                                                <td>{{ $reading['units_purchased'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@include('includes.footer')

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.4.1/chart.min.js"></script>
<script type="text/javascript">
    let ctx1 = document.getElementById("electricityCanvas").getContext('2d');
    let ctx2 = document.getElementById("waterCanvas").getContext('2d');
    ctx1.width  = 800;
    ctx1.height = 600;
    ctx2.width  = 800;
    ctx2.height = 600;
    let myChart1 = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels:<?php echo json_encode($electricityData['date']); ?>,
            datasets: [{
                label: "Units used",
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)'
                ],
                borderWidth: 1,
                data:<?php echo json_encode($electricityData['units']); ?>,
            }]
        },
        options: {
            legend: {
            display: true,
            position: 'bottom',

            labels: {
                fontColor: '#71748d',
                fontFamily: 'Circular Std Book',
                fontSize: 14,
            }
        },
    }
    });
    let myChart2 = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels:<?php echo json_encode($waterData['date']); ?>,
            datasets: [{
                label: "Units used",
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)'
                ],
                borderWidth: 1,
                data:<?php echo json_encode($waterData['units']); ?>,
            }]
        },
        options: {
            legend: {
            display: true,
            position: 'bottom',

            labels: {
                fontColor: '#71748d',
                fontFamily: 'Circular Std Book',
                fontSize: 14,
            }
        },
    }
    });
</script>