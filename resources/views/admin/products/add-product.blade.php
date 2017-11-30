@extends('layouts.dashboard-admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar-admin')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Карточка нового товара</div>
                    <div class="panel-body">
                        <div class="btn-group">
                            Категории
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle"
                                        type="button"
                                        data-toggle="dropdown">
                                    {{$category->category}}
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    @foreach($categories AS $categoryItem)
                                        <li>
                                            <a href="/admin/products/{{$categoryItem->id}}/create-product?group={{$group->id}}">
                                                @if($categoryItem->active == 1)
                                                    <b>{{$categoryItem->category}}</b>
                                                @else
                                                    {{$categoryItem->category}}
                                                @endif
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            @if($categoryActive == 1)
                                Категория активна
                            @else
                                <b style="color: red">Категория не активна</b>
                            @endif
                        </div>
                        <div class="btn-group">
                            Группы
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle"
                                        type="button"
                                        data-toggle="dropdown">
                                    {{$group->group}}
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    @foreach($groups AS $groupItem)
                                        <li>
                                            <a href="/admin/products/{{$category->id}}/create-product?group={{$groupItem->id}}">
                                                @if($groupItem->active == 1)
                                                    <b>{{$groupItem->group}}</b>
                                                @else
                                                    {{$groupItem->group}}
                                                @endif
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            @if($groupActive == 1)
                                Группа активна
                            @else
                                <b style="color: red">Группа не активна</b>
                            @endif
                        </div>
                        <hr>
                        <form method="post" action="/admin/products/add-product">
                            {{csrf_field()}}
                            <input type="text" name="group-id" value="{{$group->id}}" hidden>
                            <div class="form-group">
                                <label for="product_ru">Название товара (рус):</label>
                                <input type="text"
                                       class="form-control"
                                       id="product_ru"
                                       placeholder="Введите имя товара на русском языке"
                                       required
                                       name="product-ru">
                            </div>
                            <div class="form-group">
                                <label for="product_de">Название товара (нем):</label>
                                <input type="text"
                                       class="form-control"
                                       id="product_de"
                                       placeholder="Введите имя товара на немецком языке"
                                       required
                                       name="product-de">
                            </div>
                            <div class="form-group">
                                <label for="description">Описание товара:</label>
                                <textarea class="form-control"
                                          rows="5"
                                          name="description"
                                          id="description">
			                    </textarea>
                            </div>
                            <div class="form-group">
                                <label for="price_eur">Цена товара (EUR):</label>
                                <input type="number"
                                       class="form-control"
                                       id="price_eur"
                                       placeholder="Введите цену товара в EUR"
                                       required
                                       name="price-eur">
                            </div>
                            <div class="form-group">
                                <label for="price_rub_manual">Цена товара (RUB):</label>
                                <input type="number"
                                       class="form-control"
                                       id="price_rub_manual"
                                       placeholder="Введите вручную цену товара в RUB (Если есть необходимость)"
                                       name="price-rub-manual">
                            </div>
                            <div class="form-group">
                                <label for="price_with_discount">Акционная цена товара (RUB):</label>
                                <input type="number"
                                       class="form-control"
                                       id="price_with_discount"
                                       placeholder="Акционная цена товара в RUB"
                                       name="price-with-discount">
                            </div>
                            <div class="form-group">
                                <label for="discount_start">Дата и время начала акции:</label>
                                <input type="datetime-local"
                                       class="form-control"
                                       id="discount_start"
                                       placeholder="Начало акции"
                                       name="discount-start" >
                            </div>
                            <div class="form-group">
                                <label for="discount_end">Дата и время конца акции:</label>
                                <input type="datetime-local"
                                       class="form-control"
                                       id="discount_end"
                                       placeholder="Конец акции"
                                       name="discount-end" >
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="discount-active" value="1">
                                    Акция активна
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="weight_gr">Вес товара:</label>
                                <input type="number"
                                       class="form-control"
                                       id="weight_gr"
                                       placeholder="Вес товара"
                                       name="weight-gr" >
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="product-active" value="1">
                                    Товар активен
                                </label>
                            </div>
                            <button type="submit" class="btn btn-default">Сохранить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection