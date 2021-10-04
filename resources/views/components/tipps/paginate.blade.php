<div class="row">
    <nav class="">
        <ul class="pagination justify-content-center">
            <li class="page-item @if($currentDay <= 1) disabled @endif">
                <a class="page-link" href="{{ route('tipps', ['league' => $league, 'day' => $currentDay - 1]) }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>

            @foreach($links as $link)
                <li class="page-item @if($currentDay == $link) active @endif"><a class="page-link" href="{{ route('tipps', ['league' => $league, 'day' => $link]) }}">{{ $link }}</a></li>
            @endforeach

            <li class="page-item @if($currentDay >= 34) disabled @endif">
                <a class="page-link" href="{{ route('tipps', ['league' => $league, 'day' => $currentDay + 1]) }}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
