<form method="post" action="{{route('admin-load-order-status-update',['order',$order->id])}}">
    {{method_field('PATCH')}}
    {{csrf_field()}}
    <input type="text" name="order_id" value="{{$order->id}}" hidden>
    <div class="form-group">
        <label for="order-status">
            Статус заказа:
        </label>
        <select class="form-control" name="order_status" id="order-status">
            @foreach($orderStatusList AS $en=>$ru)
                @if($en === $order->order_status)
                    <option class="order-status" value="{{$en}}" selected>{{$ru}}</option>
                @else
                    <option value="{{$en}}">{{$ru}}</option>
                @endif
            @endforeach
        </select>
    </div>
    <div class="form-group" id="delivery-track-number">
        <label for="delivery-track">Трек посылки:</label>
        <input
                type="text"
                name="delivery_track_number"
                class="form-control"
                id="delivery-track"
                value="{{$order->delivery_track_number}}"
        >
    </div>
    <div class="form-group">
        <label for="invoice-status">
            Статус инвойса:
        </label>
        <select class="form-control" name="invoice_status" id="invoice-status">
            @foreach($invoiceStatusList AS $en=>$ru)
                @if($en === $order->invoice_status)
                    <option value="{{$en}}" selected>{{$ru}}</option>
                @else
                    <option value="{{$en}}">{{$ru}}</option>
                @endif
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Изменить статус заказа / инвойса:</label>
        <button type="submit" class="btn btn-success btn-block">Обновить</button>
    </div>
</form>
<script>
    $(document).ready(function(){
        var orderStatus = $("#order-status").val();
        if(orderStatus === 'order_sent'){
            $("#delivery-track-number").show();
        }else{
            $("#delivery-track-number").hide();
        }

        $("#order-status").change(function(){
            var orderStatus = $(this).val();
            if(orderStatus === 'order_sent'){
                $("#delivery-track-number").show();
            }
        })
    })
</script>