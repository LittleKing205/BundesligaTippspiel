require('./bootstrap');

function addAlert(color, message) {
    $('#alerts').append(
        '<div class="alert alert-' + color + '">' +
        '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
        message + '</div>'
    )
}

jQuery(document).ready(function($){
    btnHtml = [
        "<i class=\"fas fa-plus\"></i>",
        "<i class=\"fas fa-equals\"></i>",
        "<i class=\"fas fa-plus\"></i>"
    ];

    $(".tipp_btn").click(function() {
        $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        let sendData = {
            match: $(this).data('match'),
            tipp: $(this).data('btnval')
        };
        $.ajax({
            type: 'POST',
            url: $('meta[name="tipp-url"]').attr('content'),
            data: sendData,
            //dataType: 'json',
            success: function (ret) {
                if (ret.code == 200) {
                    $("body").find(`[data-match='` + ret.data.matchId + `']`).each((index, btn) => {
                        $(btn).removeClass('btn-primary');
                        $(btn).removeClass('btn-danger');
                        $(btn).removeClass('btn-info');
                        $(btn).removeClass('btn-success');
                        $(btn).removeClass('btn-secondary');
                        if (ret.data.tipp == $(btn).data('btnval')) {
                            $(btn).addClass('btn-success');
                        } else {
                            $(btn).addClass('btn-primary');
                        }
                        $(btn).html(btnHtml[index]);
                        console.log('Tipp wurde gespeichert.')
                    });
                } else {
                    console.log("Spiel wurde gesperrt.");
                    $("body").find(`[data-match='` + ret.data.matchId + `']`).each((index, btn) => {
                        $(btn).html(btnHtml[index]);
                        $(btn).prop('disabled', true);
                    });
                    addAlert('danger', ret.message);
                }
            },
            error: function (error) {
                console.error(error);
                $("body").find(`[data-match='` + error.data.matchId + `']`).each((index, btn) => {
                    $(btn).html(btnHtml[index]);
                });
                addAlert('danger', 'Ein fehler ist aufgetreten. Bitte versuche es später erneut');
            }
        });
    });
});

/*

                $("body").find(`[data-match='` + $(this).data('match') + `']`).each( (index, btn) => {
                    $( btn ).removeClass('btn-primary');
                    $( btn ).removeClass('btn-danger');
                    $( btn ).removeClass('btn-info');
                    $( btn ).removeClass('btn-success');
                    $( btn ).removeClass('btn-secondary');
                    if ( $(this).data('btnval') === $( btn ).data('btnval') ) {
                        $( btn ).addClass('btn-success');
                    } else {
                        $( btn ).addClass('btn-primary');
                    }
                    console.log( $(this) );
                });

 */
