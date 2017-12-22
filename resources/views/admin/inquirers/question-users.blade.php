@extends('layouts.dashboard-admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('layouts.sidebar-admin')
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">Ответы всех пользователей на вопрос:</div>
                <div class="panel-body">
                    <form>
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
                            <label for="question">Вопрос:</label>
                            <input type="text"
                                   class="form-control"
                                   id="question"
                                   readonly
                                   value="{{$question->question}}"
                                   name="question">
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
                            <th>Пользователь</th>
                            <th>Дата ответа</th>
                            <th>Ответ</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($question->users AS $user)
                        <tr>
                            <td>{{$user->first_name}} {{$user->last_name}}</td>
                            <td>
                                {{$user->pivot->created_at}}
                            </td>
                            <td>
                                {{$user->pivot->answer}}
                            </td>
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

