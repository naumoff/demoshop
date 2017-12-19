@extends('layouts.dashboard-admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar-admin')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Детали заказа</div>
                    <div class="panel-body">
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
                                                  rows="4"
                                                  readonly
                                                  id="address">{{$order->user_country}}, г. {{$order->user_city}}&#13;&#10;ул. {{$order->user_street}}&#13;&#10;дом {{$order->user_building_number}} кв. {{$order->user_apartment_number}}
                                        </textarea>
                                    </div>
                                </div>
                            </div>

                        </form>
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#">Товар</a></li>
                            <li><a href="#">Пакет</a></li>
                            <li><a href="#">Подарок</a></li>
                            <li><a href="#">Стоимость</a></li>
                            <li><a href="#">Адрес</a></li>
                            <li><a href="#">Партнер</a></li>
                        </ul>
                        <div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection