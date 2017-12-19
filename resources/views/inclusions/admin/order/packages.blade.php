@if($order->packages->count() > 0)
    <table class="table">
        <thead>
        <tr>
            <th>Пакет</th>
            <th>Цена EUR</th>
            <th>Цена RUB</th>
            <th>Кол-во</th>
            <th>Общий вес</th>
            <th>всего RUB</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order->packages AS $package)
            <tr>
                <td>{{$package->package_ru}}</td>
                <td>{{$package->price_eur}}</td>
                <td>
                    @if($package->price_rub_manual > 0)
                        {{$package->price_rub_manual}}
                    @else
                        {{$package->price_rub_auto}}
                    @endif
                </td>
                <td>{{$package->pivot->qty}}</td>
                <td>{{$package->pivot->weight}} гр.</td>
                <td>{{$package->pivot->cost}} руб.</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
