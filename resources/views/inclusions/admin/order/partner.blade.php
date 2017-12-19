<form>
    <div class="form-group">
        <label for="partner">Партнер:</label>
        <input
                type="text"
                class="form-control"
                id="partner"
                name="partner"
                readonly
                value="{{$order->paymentCard->paymentPartner->first_name}} {{$order->paymentCard->paymentPartner->last_name}}"
        >
    </div>
    <div class="form-group">
        <label for="bank">Банк:</label>
        <input
                type="text"
                class="form-control"
                id="bank"
                name="bank"
                readonly
                value="{{$order->paymentCard->bank}}"
        >
    </div>
    <div class="form-group">
        <label for="card">Карточка:</label>
        <input
                type="text"
                class="form-control"
                id="card"
                name="card"
                readonly
                value="{{$order->paymentCard->card_number}}"
        >
    </div>
</form>