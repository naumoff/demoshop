@extends('layouts.dashboard-admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar-admin')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Карточка добавления фотографий</div>
                    <div class="panel-body">
                        <form>
                            <div class="form-group">
                                <label for="product_name">Название продукта:</label>
                                <input
                                        type="text"
                                        name="product-name"
                                        class="form-control"
                                        id="product_name"
                                        value="{{$product->product_ru}}"
                                        readonly
                                >
                                <?php

                                ?>
                            </div>
                            <button type="submit" class="btn btn-default">Сохранить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection