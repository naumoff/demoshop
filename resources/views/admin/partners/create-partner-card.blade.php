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
                            <li>
                                <a href="#">Редактор Партнера</a>
                            </li>
                            <li class="active">
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
                                       readonly
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
                                       readonly
                                       name="last-name"
                                       value="{{$partner->last_name}}"
                                >
                            </div>
                            <button type="submit" class="btn btn-success">Добавить платежную карту</button>
                        </form>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Банк</th>
                                <th>Карточка</th>
                                <th>Лимит</th>
                                <th>Редактор</th>
                                <th>Удалить</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Naumoff</td>
                                <td>Andrey</td>
                                <td>37</td>
                            </tr>
                            <tr>
                                <td>Korbakova</td>
                                <td>Ludmila</td>
                                <td>39</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection