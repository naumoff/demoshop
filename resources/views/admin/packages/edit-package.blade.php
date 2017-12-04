@extends('layouts.dashboard-admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar-admin')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Создание пакета</div>
                    <div class="panel-body">
                        <ul class="nav nav-pills nav-justified">
                            <li class="active"><a href="#">Создание Пакета</a></li>
                            <li class="">
                                <a href="{{route('admin-create-package-products',['pack_id'=>$package->id])}}">
                                    Добавление Товара
                                </a>
                            </li>

                        </ul>
                        @include('inclusions.error-message')
                        <form method="post" action="{{route('packages.store')}}">
                            {{csrf_field()}}
                            <label for="category">
                                Выберите категорию (одну):
                            </label>
                            <select class="form-control" id="category" name="category-id">
                                @foreach($categories AS $category)
                                    @if($category->id == $package->category_id)
                                        <option selected value="{{$category->id}}">
                                            {{$category->category}}
                                        </option>
                                    @else
                                        <option>
                                            {{$category->category}}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            <div class="form-group">
                                <label for="package_ru">Название Пакета (рус):</label>
                                <input type="text"
                                       class="form-control"
                                       id="package_ru"
                                       placeholder="Введите имя пакета на русском языке"
                                       required
                                       name="package-ru"
                                       value="{{$package->package_name}}"
                                >
                            </div>
                            <div class="form-group">
                                <label for="price_rub">Цена товара (RUB):</label>
                                <input type="number"
                                       class="form-control"
                                       id="price_rub"
                                       placeholder="Введите цену товара в RUB"
                                       required
                                       name="price-rub"
                                       min="0"
                                       max="100000"
                                       step="0.0001"
                                       value="{{$package->package_price}}"
                                >
                            </div>
                            <div class="form-group">
                                <label for="package_start">Дата и время начала акции:</label>
                                <input type="datetime-local"
                                       class="form-control"
                                       id="package_start"
                                       placeholder="Начало акции"
                                       name="package-start"
                                       value="{{$packageStart}}"
                                >
                            </div>
                            <div class="form-group">
                                <label for="package_end">Дата и время конца акции:</label>
                                <input type="datetime-local"
                                       class="form-control"
                                       id="package_end"
                                       placeholder="Конец акции"
                                       name="package-end"
                                       value="{{$packageEnd}}"
                                >
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input
                                            type="checkbox"
                                            name="package-active"
                                            value=1
                                            {{($package->active == 1)?'checked':null}}
                                    >
                                    Пакет активен
                                </label>
                            </div>
                            <button type="submit" class="btn btn-success">Обновить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection