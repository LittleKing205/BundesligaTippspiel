<div class="{{ isset($size) ? $size : 'col-12' }}">
    <div class="card @if(isset($color)) bg-{{ $color }} text-white @endif mb-4">
        @if (isset($title))
            <h5 class="card-header">{{ $title }}</h5>
        @endif
        @if(isset($body))
            <div class="card-body">
                {{ $body }}
            </div>
        @endif
        @if(isset($footer))
            <div class="card-footer">{{ $footer }}</div>
        @endif
        @if(isset($link))
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small @if(isset($color)) text-white @endif stretched-link" {{ $link->attributes->merge(['href' => '#']) }}>{{ $link }}</a>
                <div class="small @if(isset($color)) text-white @endif"><i class="fas fa-angle-right"></i></div>
            </div>
        @endif
    </div>
</div>
