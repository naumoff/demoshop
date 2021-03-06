@if($order->products->count() > 0)
<table class="table">
    <thead>
    <tr>
        <th>Товар</th>
        <th>Цена EUR</th>
        <th>Цена RUB</th>
        <th>Кол-во</th>
        <th>Общий вес</th>
        <th>Всего RUB</th>
        <th>Просмотр</th>
    </tr>
    </thead>
    <tbody>
    @foreach($order->products AS $product)
    <tr>
        <td>{{$product->product_ru}}</td>
        <td>{{$product->price_eur}}</td>
        <td>
            @if($product->price_rub_manual > 0)
                {{$product->price_rub_manual}}
            @else
                {{$product->price_rub_auto}}
            @endif
        </td>
        <td>{{$product->pivot->qty}}</td>
        <td>{{$product->pivot->weight}} гр.</td>
        <td>{{$product->pivot->cost}}</td>
        <td>
            <a
                href="{{route('admin-edit-product',['prod_id'=>$product->id])}}"
                class="btn btn-info btn-xs"
                role="button"
                target="_blank"
            >
                    Просмотр
            </a>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
@endif
