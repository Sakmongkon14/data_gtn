<td>
  @if (Auth::check() && Auth::user()->status == 1)
      <a href="#">HOME</a>
  @endif
</td>