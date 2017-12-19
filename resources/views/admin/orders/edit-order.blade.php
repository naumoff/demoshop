@extends('layouts.dashboard-admin')

@section('content')
    @if(isset($tab))
        {{$tab}}
    @endif
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar-admin')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Детали заказа</div>
                    <div class="panel-body">
                        @include('inclusions.error-message');
                        <form>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="order">Заказ:</label>
                                        <input type="text"
                                               class="form-control"
                                               id="order"
                                               readonly
                                               value="{{$order->order_number}}"
                                               name="order">
                                    </div>
                                    <div class="form-group">
                                        <label for="invoice">Инвойс:</label>
                                        <input type="text"
                                               class="form-control"
                                               id="invoice"
                                               readonly
                                               value="{{$order->invoice_number}}"
                                               name="invoice">
                                    </div>
                                    <div class="form-group">
                                        <label for="date">Дата:</label>
                                        <input type="text"
                                               class="form-control"
                                               id="date"
                                               readonly
                                               value="{{$order->created_at}}"
                                               name="date">
                                    </div>
                                    <div class="form-group">
                                        <label for="partner">Партнер:</label>
                                        <input type="text"
                                               class="form-control"
                                               id="partner"
                                               readonly
                                               value="{{$paymentPartner->first_name}} {{$paymentPartner->last_name}}"
                                               name="invoice">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="address">Адрес доставки:</label>
                                        <textarea class="form-control"
                                                  rows="4"
                                                  readonly
                                                  id="address">{{$order->user_country}}, г. {{$order->user_city}}&#13;&#10;ул. {{$order->user_street}}&#13;&#10;дом {{$order->user_building_number}} кв. {{$order->user_apartment_number}}
                                        </textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Детали заказа:</label>
                                        <textarea class="form-control"
                                                  rows="5"
                                                  readonly
                                                  id="address">вес: {{$order->order_weight}} гр.&#13;&#10;доставка: {{$order->order_delivery_cost}} руб.&#13;&#10;товар: {{$order->order_goods_cost}} руб.&#13;&#10;всего:{{$order->order_total_invoice_amount}} руб.
                                        </textarea>
                                    </div>
                                </div>
                            </div>

                        </form>
                        <ul class="nav nav-tabs">
                            <li class="active tab" tab="products">
                                <a href="#">
                                    Товар <span class="badge">{{$order->products()->count()}}</span>
                                </a>
                            </li>
                            <li tab="packages" class="tab">
                                <a href="#">
                                    Пакет <span class="badge">{{$order->packages()->count()}}</span>
                                </a>
                            </li>
                            <li tab="present" class="tab">
                                <a href="#">
                                    Подарок <span class="badge">{{$order->present()->count()}}</span>
                                </a>
                            </li>
                            <li tab="partner" class="tab">
                                <a href="#">
                                    Партнер
                                </a>
                            </li>
                            <li tab="address" class="tab">
                                <a href="#">
                                    Доставка
                                </a>
                            </li>
                            <li tab="status" class="tab">
                                <a href="#">
                                    Статус
                                </a>
                            </li>
                        </ul>
                        <div id="form-loader">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    $("document").ready(function() {
        var getParams = new URLSearchParams(window.location.search);
        if(getParams.has('tab')===true){
            var tab = getParams.get('tab');
            if(tab === 'delivery'){
                $("li").removeClass('active');
                $("[tab=address]").addClass('active');
                $("#form-loader").load("{{route('admin-load-order-address',['order'=>$order->id])}}");
            }
        }else{
            $("#form-loader").load("{{route('admin-load-order-products',['order'=>$order->id])}}");
        }

        $('.tab').on('click', function () {
            $("li").removeClass('active');
            var tab = $(this).attr('tab');
            $(this).addClass('active');

            if (tab === 'products') {
                $("#form-loader").load("{{route('admin-load-order-products',['order'=>$order->id])}}");
            } else if (tab === 'packages') {
                $("#form-loader").load("{{route('admin-load-order-packages',['order'=>$order->id])}}");
            } else if (tab === 'present') {
                $("#form-loader").load("{{route('admin-load-order-present',['order'=>$order->id])}}");
            } else if (tab === 'partner') {
                $("#form-loader").load("{{route('admin-load-order-partner',['order'=>$order->id])}}");
            } else if (tab === 'address') {
                $("#form-loader").load("{{route('admin-load-order-address',['order'=>$order->id])}}");
            } else if (tab === 'status') {
                $("#form-loader").load("{{route('admin-load-order-status',['order'=>$order->id])}}");
            }
        });
    });
</script>
@endsection