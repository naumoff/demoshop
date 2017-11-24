@extends('layouts.dashboard-admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar-admin')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Зарегестрированные пользователи</div>
                    <div class="panel-body">
                        <div class="container">
                            @if(count($users)>0)
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Имя</th>
                                    <th>Эл. Адрес</th>
                                    <th>Моб. Телефон</th>
                                    <th>Страна</th>
                                    <th>Редактировать</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users AS $user)
                                    <tr>
                                        <td>{{$user['name']}}</td>
                                        <td>{{$user['email']}}</td>
                                        <td>{{$user['mobile_phone']}}</td>
                                        <td>{{$user['country']}}</td>
                                        <td><button>Редактировать</button></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $users->links() }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection