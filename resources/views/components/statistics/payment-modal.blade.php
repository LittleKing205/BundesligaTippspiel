<div class="modal fade" id="payment-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Als Bezahlt markieren?</h5>
                <button type="button" class="close" data-dismiss="payment-modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Verwendungszweck:<br />
                    <input class="payment-modal-verwendungszweck click-copy" value="1. Bundesliga // 5. Spieltag" />
                </p>
                <p>
                    Betrag:<br />
                    <input class="payment-modal-to-pay click-copy" value="5,50" /> €
                </p>
            </div>
            <div class="modal-footer">
                <form action="{{ route('statistics.pay') }}" method="post">
                    @csrf
                    @method('post')
                    <input class="payment-modal-bill-id" type="hidden" name="bill_id" value="" />
                    <button type="submit" class="btn btn-success">Als Bezahlt markieren</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="payment-modal">Abbrechen</button>
                </form>
            </div>
        </div>
    </div>
</div>
