@extends('layouts.dashboard-admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar-admin')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Заказы ожидающие оплаты:</div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Заказ</th>
                                <th>Инвойс</th>
                                <th>Платежный партнер</th>
                                <th>Клиент</th>
                                <th>Адрес</th>
                                <th>Вес</th>
                                <th>Доставка</th>
                                <th>Стоимость товара</th>
                                <th>Общая стоимость</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders AS $order)
                                <tr>
                                    <td>{{$order->order_number}}</td>
                                    <td>{{$order->invoice_number}}</td>
                                    <td>{{
                                            $order->paymentCard->paymentPartner->last_name.' '.
                                            $order->paymentCard->paymentPartner->first_name
                                        }}
                                    </td>
                                    <td>{{$order->user->name}}</td>
                                    <td></td>
                                    <td>
                                        <a class="btn btn-info btn-xs edit"
                                           href="#"
                                           id="{{$order->id}}"
                                           role="button"
                                        >
                                            Редактор
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#"
                                           id="{{$order->id}}"
                                           class="btn btn-danger btn-xs delete"
                                           role="button"
                                        >
                                            Удалить
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    $(function(){
        $(".edit").click(function(){
            var packageId = $(this).attr('id');
            var oldValue = $(this).attr('value');
            $.post
            (
                '/admin/package/status',
                {
                    "_token": "{{ csrf_token() }}",
                    'package-id':packageId,
                    'old-value':oldValue
                },
                function(data){
                    if(data === 'SUCCESS'){
                        location.reload();
                    }
                }
            );
        });
        $(".delete").click(function(){
            var packageId = $(this).attr('id');
            $.post
            (
                '/admin/packages/'+ packageId,
                {
                    "_token": "{{ csrf_token() }}",
                    "_method": "DELETE",
                },
                function(data){
                    if(data === 'SUCCESS'){
                        location.reload();
                    }else{
                        alert(data);
                    }
                }
            );
        })
    });
</script>
@endsection