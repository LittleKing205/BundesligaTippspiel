<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content {{ isset($size) ? 'modal-'.$size : '' }}">
            <div class="modal-header">
                <h5 class="modal-title">{{ isset($title) ? $title : "" }}</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            @if(isset($action))
                <form action="{{ $action }}" method="post">
                @csrf
                @if (isset($method))
                    @method($method)
                @endif
            @endif
            @if (isset($body))
                <div class="modal-body">
                    {{ $body }}
                </div>
            @endif
            @if (isset($footer))
                <div class="modal-footer">
                    {{ $footer }}
                </div>
            @endif
            @if(isset($action))
                </form>
            @endif
        </div>
    </div>
</div>
