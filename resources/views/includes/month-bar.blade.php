<ul class="nav justify-content-center border">
  @forelse ($months as $month)
    <li class="nav-item">
        <a class="btn btn-sm btn-outline-secondary" aria-current="page" href="/houses/{{$house->id}}?month={{$month}}">{{ $month }}</a>
    </li>
  @empty
      <li></li>
  @endforelse
</ul>