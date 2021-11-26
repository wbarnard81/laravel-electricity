@props(['errors'])

@if ($errors->any())
    <div {{ $attributes }}>
        <div class="fs-6 alert alert-danger">
            {{ __('Whoops! Something went wrong.') }}
        </div>

        <ul class="mt-3 alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
