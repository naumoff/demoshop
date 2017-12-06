@extends('layouts.dashboard-admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar-admin')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Редактор товара</div>
                    <div class="panel-body">
                        <ul class="nav nav-pills nav-justified">
                            <li class="active"><a href="#">Редактор Товара</a></li>
                            <li><a href="/admin/products/{{$product->id}}/edit-photo">Редактор фотографий</a></li>
                        </ul>
                        @include('inclusions.error-message')
                        <form method="post" action="{{route('presents.update')}}">
                            {{csrf_field()}}
                            {{method_field('PATCH')}}
                            <input type="text" name="id" value="{{$product->id}}" hidden>
                            <input type="text" name="group-id" value="{{$product->group_id}}" hidden>
                            <div class="form-group">
                                <label for="product_ru">Название товара (рус):</label>
                                <input type="text"
                                       class="form-control"
                                       id="product_ru"
                                       placeholder="Введите имя товара на русском языке"
                                       required
                                       name="product-ru"
                                       value="{{$product->product_ru}}"
                                >
                            </div>
                            <div class="form-group">
                                <label for="product_de">Название товара (нем):</label>
                                <input type="text"
                                       class="form-control"
                                       id="product_de"
                                       placeholder="Введите имя товара на немецком языке"
                                       required
                                       name="product-de"
                                       value="{{$product->product_de}}"
                                >
                            </div>
                            <div class="form-group">
                                <label for="description">Описание товара:</label>
                                <textarea class="form-control"
                                          rows="5"
                                          name="description"
                                          id="description"
                                >{{$product->description}}"
			                    </textarea>
                            </div>
                            <div class="form-group">
                                <label for="price_eur">Цена товара (EUR):</label>
                                <input type="number"
                                       class="form-control"
                                       id="price_eur"
                                       placeholder="Введите цену товара в EUR"
                                       required
                                       name="price-eur"
                                       min="0"
                                       max="100000"
                                       step="0.0001"
                                       value="{{$product->price_eur}}"
                                >
                            </div>
                            <div class="form-group">
                                <label for="price_rub_manual">Автоматическая цена товара (RUB):</label>
                                <input type="number"
                                       class="form-control"
                                       id="price_rub_manual"
                                       placeholder="Введите вручную цену товара в RUB (Если есть необходимость)"
                                       name="price-rub-manual"
                                       min="0"
                                       max="10000000"
                                       step="0.0001"
                                       value="{{$product->price_rub_auto}}"
                                       readonly
                                >
                            </div>
                            <div class="form-group">
                                <label for="price_rub_manual">Цена товара (RUB):</label>
                                <input type="number"
                                       class="form-control"
                                       id="price_rub_manual"
                                       placeholder="Введите вручную цену товара в RUB (Если есть необходимость)"
                                       name="price-rub-manual"
                                       min="0"
                                       max="10000000"
                                       step="0.0001"
                                       value="{{$product->price_rub_manual}}"
                                >
                            </div>
                            <div class="form-group">
                                <label for="price_with_discount">Акционная цена товара (RUB):</label>
                                <input type="number"
                                       class="form-control"
                                       id="price_with_discount"
                                       placeholder="Акционная цена товара в RUB"
                                       name="price-with-discount"
                                       min="0"
                                       max="10000000"
                                       step="0.0001"
                                       value="{{$product->price_with_discount}}"
                                >
                            </div>
                            <div class="form-group">
                                <label for="discount_start">Дата и время начала акции:</label>
                                <input type="datetime-local"
                                       class="form-control"
                                       id="discount_start"
                                       placeholder="Начало акции"
                                       name="discount-start"
                                       value="{{$product->discount_start}}"
                                >
                            </div>
                            <div class="form-group">
                                <label for="discount_end">Дата и время конца акции:</label>
                                <input type="datetime-local"
                                       class="form-control"
                                       id="discount_end"
                                       placeholder="Конец акции"
                                       name="discount-end"
                                       value="{{$product->discount_end}}"
                                >
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input
                                            type="checkbox"
                                            name="discount-active"
                                            value=1
                                            {{($product->discount_active ==1)?'checked':''}}
                                    >
                                    Акция активна
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="weight_gr">Вес товара:</label>
                                <input type="number"
                                       class="form-control"
                                       id="weight_gr"
                                       placeholder="Вес товара"
                                       name="weight-gr"
                                       value="{{$product->weight_gr}}"
                                       required
                                >
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input
                                            type="checkbox"
                                            name="product-active"
                                            value=1
                                            {{($product->active ==1)?'checked':''}}
                                    >
                                    Товар активен
                                </label>
                            </div>
                            <button type="submit" class="btn btn-success">Сохранить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection