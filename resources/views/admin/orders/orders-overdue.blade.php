@extends('layouts.dashboard-admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar-admin')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Заказы c с просроченной оплатой:</div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Документы</th>
                                <th>Клиент</th>
                                <th>Адрес</th>
                                <th>Данные по заказу</th>
                                <th>Детали</th>
                                <th>Удалить</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders AS $order)
                                <tr>
                                    <td>
                                        Заказ:{{$order->order_number}}<br>
                                        Инвойс: {{$order->invoice_number}}<br>
                                        Создан: {{$order->created_at}}<br>
                                        Партнер:
                                        {{
                                            $order->paymentCard->paymentPartner->last_name.' '.
                                            $order->paymentCard->paymentPartner->first_name
                                        }}
                                    </td>
                                    <td>
                                        {{$order->user->name}}<br>
                                        {{$order->user_email}}<br>
                                        {{$order->user_phone}}
                                    </td>
                                    <td>
                                        {{$order->user_country}}, {{$order->user_city}}<br>
                                        ул. {{$order->user_street}}<br>
                                        дом {{$order->user_building_number}}
                                        кв. {{$order->user_apartment_number}}
                                    </td>
                                    <td>
                                        вес: {{$order->order_weight}} гр. <br>
                                        доставка: {{$order->order_delivery_cost}} руб.<br>
                                        товар: {{$order->order_goods_cost}} руб. <br>
                                        <b>всего:</b> {{$order->order_total_invoice_amount}} руб.
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-xs"
                                           href="{{route('admin-order-edit',$order->id)}}"
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
            $(".delete").click(function(){
                var orderId = $(this).attr('id');
                $.post
                (
                    '/admin/orders/'+ orderId,
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