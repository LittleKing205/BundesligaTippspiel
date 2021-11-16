<div @if(isset($id)) id="{{ $id }}" @endif class="{{ isset($size) ? $size : 'col-12' }}">
    <div class="card @if(isset($color)) bg-{{ $color }} text-white @endif mb-3">
        @if (isset($title))
            @if (isset($color) || (isset($smallTitle) && $smallTitle == true))
                <div class="card-header">{{ $title }}</div>
            @else
                <h5 class="card-header">{{ $title }}</h5>
            @endif
        @endif
        @if(isset($body))
            <div {{ $body->attributes->merge(['class' => 'card-body']) }}>
                {{ $body }}
            </div>
        @endif
        @if(isset($footer))
            <div {{ $footer->attributes->merge(['class' => 'card-footer']) }}>{{ $footer }}</div>
        @endif
        @if(isset($link))
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small @if(isset($color)) text-white @endif stretched-link" {{ $link->attributes->merge(['href' => '#']) }}>{{ $link }}</a>
                <div class="small @if(isset($color)) text-white @endif"><i class="fas fa-angle-right"></i></div>
            </div>
        @endif
    </div>
</div>
