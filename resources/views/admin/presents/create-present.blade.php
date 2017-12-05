@extends('layouts.dashboard-admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar-admin')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Создание подарка</div>
                    <div class="panel-body">
                        @include('inclusions.error-message')
                        <form method="post" action="{{route('presents.store')}}" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="present_ru">Название Подарка (рус):</label>
                                <input type="text"
                                       class="form-control"
                                       id="present_ru"
                                       placeholder="Введите имя подарка на русском языке"
                                       required
                                       name="present-ru"
                                       value="{{old('present-ru')}}"
                                >
                            </div>
                            <div class="form-group">
                                <label for="present_de">Название Подарка (нем):</label>
                                <input type="text"
                                       class="form-control"
                                       id="present_de"
                                       placeholder="Введите имя подарка на немецком языке"
                                       required
                                       name="present-de"
                                       value="{{old('present-de')}}"
                                >
                            </div>
                            <div class="form-group">
                                <label for="description">Описание подарка:</label>
                                <textarea class="form-control"
                                          rows="3"
                                          id="description"
                                          name="description"
                                          required
                                >{{old('description')}}
                    			</textarea>
                            </div>
                            <div class="form-group">
                                <label for="weight_gr">Вес подарка (гр):</label>
                                <input type="number"
                                       min="1"
                                       max="2000000"
                                       step="1"
                                       class="form-control"
                                       id="weight_gr"
                                       placeholder="Введите вес подарка"
                                       name="weight-gr"
                                       value="{{old('weight-gr')}}"
                                       required
                                >
                            </div>
                            <div class="form-group">
                                <label for="min_order_value_rub">Минимальный заказ:</label>
                                <input type="number"
                                       min="1"
                                       max="2000000"
                                       step="0.01"
                                       class="form-control"
                                       id="min_order_value_rub"
                                       placeholder="Введите минимальные условия получения подарка"
                                       name="min-order-value-rub"
                                       value="{{old('min-order-value-rub')}}"
                                       required
                                >
                            </div>
                            <div class="form-group">
                                <label for="max_order_value_rub">Максимальный заказ:</label>
                                <input type="number"
                                       min="1"
                                       max="2000000"
                                       step="0.01"
                                       class="form-control"
                                       id="max_order_value_rub"
                                       placeholder="Введите максимальные условия получения подарка"
                                       name="max-order-value-rub"
                                       value="{{old('max-order-value-rub')}}"
                                       required
                                >
                            </div>
                            <span class="btn btn-default btn-file">
                            <span>Выберите файл</span>
                            <input type="file" name="urls[]" multiple required /></span>
                            <span class="fileinput-filename"></span>
                            <div class="checkbox">
                                <label>
                                    <input
                                        type="checkbox"
                                        name="active"
                                        value=1
                                        {{(old('active')==1)?'checked':null}}
                                    >
                                    Подарок активен
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