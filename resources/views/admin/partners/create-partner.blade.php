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
                                <a href="#">Редактор карточек</a>
                            </li>
                        </ul>
                        @include('inclusions.error-message')
                        <form method="post" action="{{route('partners.store')}}">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="first_name">Имя партнера:</label>
                                <input type="text"
                                       class="form-control"
                                       id="first_name"
                                       placeholder="Введите имя партнера"
                                       required
                                       name="first-name"
                                       value="{{old('first-name')}}"
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
                                       value="{{old('last-name')}}"
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
                                       value="{{old('email')}}"
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
                                       value="{{(old('total-limit-eur')!==null)?old('total-limit-eur'):5000}}"
                                       required
                                >
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input
                                        type="checkbox"
                                        name="active"
                                        value=1
                                        {{(old('active')==1)?'checked':null}}
                                    >
                                    Партнер работает
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