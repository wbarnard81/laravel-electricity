<ul class="nav justify-content-center border">
  @forelse ($years as $year)
    <li class="nav-item">
        <a class="btn btn-outline-secondary" aria-current="page" href="/houses/{{$house->id}}?year={{$year}}">{{ $year }}</a>
    </li>
  @empty
      <li></li>
  @endforelse
</ul>