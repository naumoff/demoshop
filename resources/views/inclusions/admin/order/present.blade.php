@if($order->present->count() > 0)
    <table class="table">
        <thead>
        <tr>
            <th>Подарок</th>
            <th>Вес подарка</th>
            <th>Просмотр</th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{$order->present->present_ru}}</td>
                <td>{{$order->present->weight_gr}} гр.</td>
                <td>
                    <a
                            href="{{route('presents.edit',['present'=>$order->present->id])}}"
                            class="btn btn-info btn-xs"
                            role="button"
                            target="_blank"
                    >
                        Просмотр
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
@endif