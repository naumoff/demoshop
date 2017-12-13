@extends('layouts.dashboard-admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar-admin')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Создание партнера</div>
                    <div class="panel-body">
                        <ul class="nav nav-pills nav-justified">
                            <li class="active">
                                <a href="#">Редактор Партнера</a>
                            </li>
                            <li>
                                <a href="{{route('admin-partner-add-card',['part_id'=>$partner->id])}}">
                                    Редактор карточек
                                </a>
                            </li>
                        </ul>
                        @include('inclusions.error-message')
                        <form method="post" action="{{route('partners.update',['partner'=>$partner->id])}}">
                            {{csrf_field()}}
                            {{method_field('PATCH')}}
                            <input type="text" name="partner-id" value="{{$partner->id}}" hidden >
                            <div class="form-group">
                                <label for="sequence">Порядок ротации:</label>
                                <input type="text"
                                       class="form-control"
                                       id="sequence"
                                       placeholder="Порядок ротации"
                                       required
                                       name="sequence"
                                       value="{{$partner->sequence}}"
                                >
                            </div>                            <div class="form-group">
                                <label for="first_name">Имя партнера:</label>
                                <input type="text"
                                       class="form-control"
                                       id="first_name"
                                       placeholder="Введите имя партнера"
                                       required
                                       name="first-name"
                                       value="{{$partner->first_name}}"
                                >
                            </div>
                            <div class="form-group">
                                <label for="last_name">Фамилия партнера:</label>
                                <input type="text"
                                       class="form-control"
                                       id="last_name"
                                       placeholder="Введите фамилию партнера"
                                       required
                                       name="last-name"
                                       value="{{$partner->last_name}}"
                                >
                            </div>
                            <div class="form-group">
                                <label for="email">Эл. адрес:</label>
                                <input type="email"
                                       class="form-control"
                                       id="email"
                                       placeholder="Введите эл. адрес партнера"
                                       required
                                       name="email"
                                       value="{{$partner->email}}"
                                >
                            </div>
                            <div class="form-group">
                                <label for="total_limit_eur">Лимит по обороту в месяц (EUR):</label>
                                <input type="number"
                                       min="1"
                                       max="200000"
                                       step="0.01"
                                       class="form-control"
                                       id="total_limit_eur"
                                       placeholder="Введите ежемесячный лимит по обороту в Евро"
                                       name="total-limit-eur"
                                       value="{{$partner->total_limit_eur}}"
                                       required
                                >
                            </div>
                            <div class="form-group">
                                <label for="total_cards_eur">Сумма лимита по всем активным карточкам (EUR):</label>
                                <input type="number"
                                       class="form-control"
                                       id="total_cards_eur"
                                       name="total-cards-eur"
                                       value="{{$partner->total_cards_eur}}"
                                       required
                                       readonly
                                >
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input
                                            type="checkbox"
                                            name="active"
                                            value=1
                                            {{($partner->active==1)?'checked':null}}
                                    >
                                    Партнер работает
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