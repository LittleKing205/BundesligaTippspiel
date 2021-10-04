require('./bootstrap');

function addAlert(color, message) {
    $('#alerts').append(
        '<div class="alert alert-' + color + '">' +
        '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
        message + '</div>'
    )
}

jQuery(document).ready(function($){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
    btnHtml = [
        "<i class=\"fas fa-plus\"></i>",
        "<i class=\"fas fa-equals\"></i>",
        "<i class=\"fas fa-plus\"></i>"
    ];

    $(".tipp_btn").click(function() {
        $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
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
                    });
                    console.log('Tipp wurde gespeichert.');
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
                console.error(error);
                addAlert('danger', 'Ein fehler ist aufgetreten. Bitte versuche es später erneut');
            }
        });
    });

    $("#activateSmsSendTokenBtn").click(function() {
        console.log("Request SMS sending");
        let sendData = {
            number: $("#activateTelefonNummerInput").val()
        };
        $.ajax({
            type: 'POST',
            url: $('meta[name="get-sms-token-url"]').attr('content'),
            data: sendData,
            success: function (ret) {
                console.log("SMS was sendet");
                $("#activateTelefonNummerInput").prop("disabled", true);
                $("#telefonnummerConfirmTokenField").removeClass("d-none");
                $("#storeNumberBtn").removeClass("d-none");
                $("#activateSmsSendTokenBtn").addClass("d-none");
            },
            error: function (error) {
                addAlert('danger', 'Ein fehler ist aufgetreten. Bitte versuche es später erneut');
            }
        });
    });

    $("#storeNumberBtn").click(function() {
        console.log("Request Save SMS Token");
        let sendData = {
            number: $("#activateTelefonNummerInput").val(),
            token: $("#checkToken").val()
        };
        $.ajax({
            type: 'POST',
            url: $('meta[name="store-number-url"]').attr('content'),
            data: sendData,
            success: function (ret) {
                console.log("Number for SMS Notifications saved")
                location.reload();
            },
            error: function (error) {
                addAlert('danger', 'Ein fehler ist aufgetreten. Bitte versuche es später erneut');
            }
        });
    });

    $("#storeJoinBtn").click(function() {
        $.get("https://joinjoaomgcd.appspot.com/_ah/api/registration/v1/listDevices?apikey="+$("#activateJoinInput").val())
            .done(function(data) {
                if(data.success) {
                    let sendData = {
                        join_key: $("#activateJoinInput").val()
                    };
                    $.ajax({
                        type: 'POST',
                        url: $('meta[name="store-join-url"]').attr('content'),
                        data: sendData,
                        success: function (ret) {
                            location.reload();
                        },
                        error: function (error) {
                            addAlert('danger', 'Ein fehler ist aufgetreten. Bitte versuche es später erneut.');
                        }
                    });
                } else {
                    addAlert('danger', 'Du hast anscheinend einen falschen Key eingegeben.');
                }
            })
            .fail(function(error) {
                addAlert('danger', 'Ein fehler ist aufgetreten. Bitte versuche es später erneut.');
            });
    });

    $(".statistics-pay-btn").click(function() {
        $(".payment-modal-verwendungszweck").val($(this).data("league") + ". Bundesliga // " + $(this).data("day") + ". Spieltag");
        $(".payment-modal-to-pay").val($(this).data("betrag"))
        $(".payment-modal-bill-id").val($(this).data("id"))
        $("#payment-modal").modal("show");
    });

    $(".click-copy").click(function() {
        console.log("Click Copy");
        $(this).select();
        document.execCommand("copy");
    });

    $("button").click(function() {
        console.log("Button Clicked");
        if ($(this).data("dismiss") === "payment-modal") {
            $("#payment-modal").modal("hide");
        }
    });
});
