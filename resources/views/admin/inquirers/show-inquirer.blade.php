@extends('layouts.dashboard-admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('layouts.sidebar-admin')
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">Детали опросника:</div>
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
                            <label for="created">Создан:</label>
                            <input type="text"
                                   class="form-control"
                                   id="created"
                                   readonly
                                   value="{{$inquirer->created_at}}"
                                   name="created">
                        </div>
                        <div class="form-group">
                            <label for="users">Количество ответивших пользователей:</label>
                            <input type="text"
                                   class="form-control"
                                   id="users"
                                   readonly
                                   value="{{$inquirer->questions->first()->users->count()}}"
                                   name="users">
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
                    <ul class="nav nav-tabs">
                        <li tab="questions" class="active tab">
                            <a data-toggle="tab" href="#home">Вопросы</a>
                        </li>
                        <li tab="users" class="tab">
                            <a data-toggle="tab" href="#menu1">Ответившие</a>
                        </li>
                    </ul>
                    <div id="form-loader"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){

        $("#form-loader").load("{{route('admin-load-inquirer-questions',['inquirer'=>$inquirer->id])}}");

        $('.tab').on('click', function () {
            $("li").removeClass('active');
            var tab = $(this).attr('tab');
            $(this).addClass('active');

            if (tab === 'questions') {
                $("#form-loader").load("{{route('admin-load-inquirer-questions',['inquirer'=>$inquirer->id])}}");
            } else if (tab === 'users') {
                $("#form-loader").load("{{route('admin-load-inquirer-users',['inquirer'=>$inquirer->id])}}");
            }
        });
    });
</script>
@endsection