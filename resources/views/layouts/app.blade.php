@include('includes.header')
@include('components.navbar')
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            {{ $header }}
        </div>
    </header>

    <main>
        {{ $slot }}
    </main>
@include('includes.footer')