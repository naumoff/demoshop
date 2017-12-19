<div class="container">
    @if($order->present->count() > 0)
        <table class="table">
            <thead>
            <tr>
                <th>Подарок</th>
                <th>Вес подарка</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$order->present->present_ru}}</td>
                    <td>{{$order->present->weight_gr}} гр.</td>
                </tr>
            </tbody>
        </table>
    @endif
</div>