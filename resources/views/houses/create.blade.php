@include('includes.header')
@include('components.navbar')
    <section class="p-5 text-center">
        <div class="col-6" style="margin-left: 25%;">
        @if (session('slug'))
            <div class="alert alert-danger">
                {{ session('slug') }}
            </div>
        @endif
            <form method="POST" action="/houses/store" class="row g-3">
                @csrf
                <div class="col-12">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') {{'is-invalid'}} @enderror" name="name" placeholder="Home" value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="complex" class="form-label">Complex Name & Number (optional)</label>
                    <input type="text" class="form-control @error('complex') {{'is-invalid'}} @enderror" name="complex" placeholder="Sun Valley 1" value="{{ old('complex') }}">
                    @error('complex')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control @error('address') {{'is-invalid'}} @enderror" name="address" placeholder="1234 Main St" value="{{ old('address') }}">
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="city" class="form-label">City</label>
                    <input type="text" class="form-control @error('city') {{'is-invalid'}} @enderror" name="city" placeholder="Johannesburg" value="{{ old('city') }}">
                    @error('city')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="province" class="form-label">Province</label>
                    <select name="province" class="form-select @error('province') {{'is-invalid'}} @enderror">
                        <option selected>Choose...</option>
                        <option {{ old('province') == "Gauteng" ? "selected" : "" }} value="Gauteng">Gauteng</option>
                        <option {{ old('province') == "Free State" ? "selected" : "" }} value="Free State">Free State</option>
                        <option {{ old('province') == "KwaZulu-Natal" ? "selected" : "" }} value="KwaZulu-Natal">KwaZulu-Natal</option>
                        <option {{ old('province') == "Limpopo" ? "selected" : "" }} value="Limpopo">Limpopo</option>
                        <option {{ old('province') == "Mpumalanga" ? "selected" : "" }} value="Mpumalanga">Mpumalanga</option>
                        <option {{ old('province') == "North West" ? "selected" : "" }} value="North West">North West</option>
                        <option {{ old('province') == "Eastern Cape" ? "selected" : "" }} value="Eastern Cape">Eastern Cape</option>
                        <option {{ old('province') == "Northern Cape" ? "selected" : "" }} value="Northern Cape">Northern Cape</option>
                        <option {{ old('province') == "Western Cape" ? "selected" : "" }} value="Western Cape">Western Cape</option>
                    </select>
                    @error('province')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2">
                    <label for="postal_code" class="form-label">Zip</label>
                    <input type="text" class="form-control @error('postal_code') {{'is-invalid'}} @enderror" name="postal_code" placeholder="0001" value="{{ old('postal_code') }}">
                    @error('postal_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-dark">Add Home</button>
                </div>
            </form>
        </div>
    </section>
@include('includes.footer')