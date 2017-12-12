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
                            <li class=""><a href="#">Добавление Товара</a></li>

                        </ul>
                        @include('inclusions.error-message')
                        <form method="post" action="{{route('packages.store')}}">
                            {{csrf_field()}}
                            <label for="category">
                                Выберите категорию (одну):
                            </label>
                            <select class="form-control" id="category" name="category-id">
                                @foreach($categories AS $category)
                                    @if($category->active == 1)
                                        <option value="{{$category->id}}" style="font-weight: bold">
                                            {{$category->category}}
                                        </option>
                                    @else
                                        <option value="{{$category->id}}">
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
                                       value=""
                                >
                            </div>
                            <div class="form-group">
                                <label for="package_de">Название Пакета (нем):</label>
                                <input type="text"
                                       class="form-control"
                                       id="package_de"
                                       placeholder="Введите имя пакета на немецком языке"
                                       required
                                       name="package-de"
                                       value=""
                                >
                            </div>

                            <div class="form-group">
                                <label for="package_start">Дата и время начала акции:</label>
                                <input type="datetime-local"
                                       class="form-control"
                                       id="package_start"
                                       placeholder="Начало акции"
                                       name="package-start"
                                       value=""
                                >
                            </div>
                            <div class="form-group">
                                <label for="package_end">Дата и время конца акции:</label>
                                <input type="datetime-local"
                                       class="form-control"
                                       id="package_end"
                                       placeholder="Конец акции"
                                       name="package-end"
                                       value=""
                                >
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input
                                            type="checkbox"
                                            name="package-active"
                                            value=1
                                    >
                                    Пакет активен
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