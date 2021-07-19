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

        <div class="p-4 text-center">
            <div>
                <div class="row mb-4">
                    @if ($house->meters)
                        <div class="d-flex justify-content-between">
                            @foreach ($house->meters as $meter)
                                <div class="col m-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-3">
                                                    <form action="/meter/reading/{{ $meter->id }}" method="post">
                                                        @csrf
                                                        <div class="input-group mb-3">
                                                            <input type="text" name="start_reading{!! $meter->id !!}" class="form-control @error('start_reading{{ $meter->id }}') {{'is-invalid'}} @enderror" placeholder="Start Reading" aria-label="Start Reading" aria-describedby="button-addon2" value="{{ old('start_reading{!! $meter->id !!}') }}">
                                                            @error('start_reading{{ $meter->id }}')
                                                                <div class="">{{ $message }}</div>
                                                            @enderror 
                                                            <button class="btn btn-outline-dark" type="submit">Add</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-6">
                                                    <form action="/meter/reading/{{ $meter->id }}" method="post">
                                                        @csrf
                                                        <div class="input-group mb-3">
                                                            <input type="text" name="units_purchased{!! $meter->id !!}" class="form-control @error('units_purchased{{ $meter->id }}') {{'is-invalid'}} @enderror" placeholder="Units Purchased" aria-label="Units Purchased" aria-describedby="button-addon2" value="{{ old('units_purchased{!! $meter->id !!}') }}">
                                                            @error('units_purchased{{ $meter->id }}')
                                                                <div class="">{{ $message }}</div>
                                                            @enderror
                                                            
                                                            <input type="text" name="rand_value{!! $meter->id !!}" class="form-control @error('rand_value{{ $meter->id }}') {{'is-invalid'}} @enderror" placeholder="Rand Value" aria-label="Rand Value" aria-describedby="button-addon2" value="{{ old('rand_value{!! $meter->id !!}') }}">
                                                            @error('rand_value{{ $meter->id }}')
                                                                <div class="">{{ $message }}</div>
                                                            @enderror
                                                            <button class="btn btn-outline-dark" type="submit">Add</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-3">
                                                    <form action="/meter/reading/{{ $meter->id }}" method="post">
                                                        @csrf
                                                        <div class="input-group mb-3">
                                                            <input type="text" name="reading{!! $meter->id !!}" class="form-control @error('reading{{ $meter->id }}') {{'is-invalid'}} @enderror" placeholder="Meter Reading" aria-label="Meter Reading" aria-describedby="button-addon2" value="{{ old('reading{!! $meter->id !!}') }}">
                                                            @error('reading{{ $meter->id }}')
                                                                <div class="">{{ $message }}</div>
                                                            @enderror
                                                            <button class="btn btn-outline-dark" type="submit">Add</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <h3 class="card-title">{{ $meter->meter_name }}</h3>
                                            <div class="row align-items-start">
                                                <div class="col">
                                                    <canvas id="{{ $meter->type }}" ></canvas>
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
                                                            @if ($meter->meterReadings)
                                                                @foreach ($meter->meterReadings as $reading)
                                                                    <tr>
                                                                        <td>{{ date("Y/m/d", strtotime($reading['created_at'])) }}</td>
                                                                        <td>{{ $reading['previous_reading'] }}</td>
                                                                        <td>{{ $reading['reading'] }}</td>
                                                                        <td>{{ intval($reading['previous_meter_reading']) - intval($reading['meter_reading']) - intval($reading['units_purchased']) }}</td>
                                                                        <td>{{ $reading['units_purchased'] }}</td>
                                                                    </tr>
                                                                @endforeach                                                                
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                    
                            @endforeach
                        </div>
                    @else
                        <div>No meters to display. Start by adding a bouse.</div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@include('includes.footer')

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.4.1/chart.min.js"></script>
<script type="text/javascript">
    let ctx1 = document.getElementById("electricity").getContext('2d');
    let ctx2 = document.getElementById("water").getContext('2d');
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