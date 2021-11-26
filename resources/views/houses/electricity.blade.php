@include('includes.header')
@include('components.navbar')
<div class="container">
  <div class="row">
    <main role="main" class="ml-sm-auto px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div>
          <h1 class="h2">Viewing: {{ $house->name }}</h1>
          <p>
            <small>{{ $house->complex }}, {{ $house->address }}, {{ $house->city }}, {{ $house->province }}, {{ $house->postal_code }}</small>
          </p>
          <div>
            <a href="/houses/{{ $house->id }}/water" class="btn btn-sm btn-primary">Water Readings</a>
          </div>
        </div>
      </div>

      <section>
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
            <div class="row g-2">
              @empty($months)
              <div class="col-sm-3">
                <form action="/houses/{{$house->id}}/meters/{{$house->meters[0]->id}}/readings/start_reading" method="POST">
                  @csrf
                  <div class="input-group">
                    <input type="text" name="start_reading" class="form-control @error('start_reading') {{'is-invalid'}} @enderror" {{ count($months) > 0 ? 'readonly' : '' }} placeholder="Start Reading" aria-label="Start Reading" value="{{ old('start_reading') }}">
                    <button class="btn btn-outline-dark @if (count($months) > 0) {{'disabled'}} @endif" type="submit">Add</button>
                  </div>
                  @error('start_reading')
                  <div class="text-danger"><small>{{ $message }}</small></div>
                  @enderror
                </form>
              </div>
              @endempty
              <div class="col-sm-6">
                <form action="/houses/{{$house->id}}/meters/{{$house->meters[0]->id}}/readings/units_purchased" method="POST">
                  @csrf
                  <div class="input-group">
                    <input type="text" name="units_purchased" class="form-control @error('units_purchased') {{'is-invalid'}} @enderror" {{ count($months) == 0 ? 'readonly' : '' }} placeholder="Units Purchased" aria-label="Units Purchased" value="{{ old('units_purchased') }}">

                    <input type="text" name="rand_value" class="form-control @error('rand_value') {{'is-invalid'}} @enderror" {{ count($months) == 0 ? 'readonly' : '' }} placeholder="Rand Value" aria-label="Rand Value" value="{{ old('rand_value') }}">
                    <button class="btn btn-outline-dark @if (count($months) == 0) {{'disabled'}} @endif" type="submit">Add</button>
                  </div>
                  @error('units_purchased')
                  <div class="text-danger">
                    <small>{{ $message }}</small>
                  </div>
                  @enderror
                  @error('rand_value')
                  <div class="text-danger">
                    <small>{{ $message }}</small>
                  </div>
                  @enderror
                </form>
              </div>
              <div class="col-sm-3">
                <form action="/houses/{{$house->id}}/meters/{{$house->meters[0]->id}}/readings/reading" method="POST">
                  @csrf
                  <div class="input-group">
                    <input type="text" name="reading" class="form-control @error('reading') {{'is-invalid'}} @enderror" {{ count($months) == 0 ? 'readonly' : '' }} placeholder="Meter Reading" aria-label="Meter Reading" value="{{ old('reading') }}">
                    <button class="btn btn-outline-dark @if (count($months) == 0) {{'disabled'}} @endif" type="submit">Add</button>
                  </div>
                  @error('reading')
                  <div class="text-danger">
                    <small>{{ $message }}</small>
                  </div>
                  @enderror
                </form>
              </div>
            </div>

            <div class="row mt-2">
              <div class="col">
                <ul class="nav justify-content-center border">
                  @forelse ($years as $year)
                  <li class="nav-item">
                    <a class="btn btn-sm btn-outline-secondary" aria-current="page" href="/houses/{{$house->id}}/{{$house->meters[0]->type}}?year={{$year}}">{{ $year }}</a>
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
                    <a class="btn btn-sm btn-outline-secondary" aria-current="page" href="/houses/{{$house->id}}/{{$house->meters[0]->type}}?month={{$month}}">{{ $month }}</a>
                  </li>
                  @empty
                  <li></li>
                  @endforelse
                </ul>
              </div>
            </div>

            <div class="container-fluid">
              <div>
                <div class="col-sm p-0 w-100 h-50 border-bottom pb-4" style="position: relative;">
                  <canvas id="canvas"></canvas>
                </div>
                <div class="col-sm p-0 pt-4 table-responsive-sm">
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
        </div>
      </section>
    </main>
  </div>
</div>

@include('includes.footer')

@include('includes.canvas')