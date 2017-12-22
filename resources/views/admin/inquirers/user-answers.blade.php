@extends('layouts.dashboard-admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('layouts.sidebar-admin')
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">Все ответы пользователя на анкету:</div>
                <div class="panel-body">
                    <form>
                        <div class="form-group">
                            <label for="user">Пользователь:</label>
                            <input type="text"
                                   class="form-control"
                                   id="user"
                                   readonly
                                   value="{{$user->first_name}} {{$user->last_name}}"
                                   name="user">
                        </div>
                        <div class="form-group">
                            <label for="inquirer">Опросник:</label>
                            <input type="text"
                                   class="form-control"
                                   id="inquirer"
                                   readonly
                                   value="{{$inquirer->inquirer}}"
                                   name="inquirer">
                        </div>
                        <div class="form-group">
                            <label for="created">Анкета заполнена:</label>
                            <input type="text"
                                   class="form-control"
                                   id="created"
                                   readonly
                                   value="{{$questionUser->first()->created_at}}"
                                   name="created">
                        </div>
                        @if($inquirer->active === 1)
                            <button type="button" class="btn btn-primary">
                                <b>Опросник активен</b>
                            </button>
                        @else
                            <button type="button" class="btn btn-default">
                                <b>Опросник неактивен</b>
                            </button>
                        @endif
                    </form>
                    <hr>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Вопрос</th>
                                <th>Ответ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($questionUser AS $answer)
                            <tr>
                                <td>{{$answer->question->question}}</td>
                                <td>{{$answer->answer}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{route('inquirers.show',['inquirer'=>$inquirer->id])}}"
                       class="btn btn-info btn-block"
                       role="button"
                    >
                        Назад
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
