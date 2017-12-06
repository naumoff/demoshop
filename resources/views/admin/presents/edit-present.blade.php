@extends('layouts.dashboard-admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar-admin')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Редактирование подарка</div>
                    <div class="panel-body">
                        <ul class="nav nav-pills nav-justified">
                            <li class="active"><a href="#">Редактор Подарка</a></li>
                            <li><a href="/admin/presents/{{$present->id}}/edit-photo">Редактор фотографий</a></li>
                        </ul>
                        @include('inclusions.error-message')
                        <form method="post" action="{{route('presents.update',['id'=>$present->id])}}">
                            {{csrf_field()}}
                            {{method_field('PATCH')}}
                            <input type="text" name="present-id" value="{{$present->id}}" hidden>
                            <div class="form-group">
                                <label for="present_ru">Название Подарка (рус):</label>
                                <input type="text"
                                       class="form-control"
                                       id="present_ru"
                                       placeholder="Введите имя подарка на русском языке"
                                       required
                                       name="present-ru"
                                       value="{{$present->present_ru}}"
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
                                       value="{{$present->present_de}}"
                                >
                            </div>
                            <div class="form-group">
                                <label for="description">Описание подарка:</label>
                                <textarea class="form-control"
                                          rows="3"
                                          id="description"
                                          name="description"
                                          required
                                >{{$present->description}}
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
                                       value="{{$present->weight_gr}}"
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
                                       value="{{$present->min_order_value_rub}}"
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
                                       value="{{$present->max_order_value_rub}}"
                                       required
                                >
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input
                                        type="checkbox"
                                        name="active"
                                        value=1
                                        {{($present->active==1)?'checked':null}}
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