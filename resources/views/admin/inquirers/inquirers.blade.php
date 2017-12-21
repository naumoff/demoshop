@extends('layouts.dashboard-admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar-admin')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Опросники:</div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Опросник</th>
                                <th>Вопросы</th>
                                <th>Ответивших</th>
                                <th>Активность</th>
                                <th>Просмотр</th>
                                <th>Удалить</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($inquirers AS $inquirer)
                                <tr>
                                    <td>
                                        {{$inquirer->inquirer}}
                                    </td>
                                    <td>
                                        {{$inquirer->questions()->count()}}
                                    </td>
                                    <td>
                                        {{$inquirer->questions->first()->users->count()}}
                                    </td>
                                    <td>
                                        {{$inquirer->active}}
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-xs"
                                           href="{{route('inquirers.show',['inquirer'=>$inquirer->id])}}"
                                           id="{{$inquirer->id}}"
                                           role="button"
                                        >
                                            Просмотр
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#"
                                           id="{{$inquirer->id}}"
                                           class="btn btn-danger btn-xs delete"
                                           role="button"
                                        >
                                            Удалить
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $inquirers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function(){
            $(".delete").click(function(){
                var orderId = $(this).attr('id');
                $.post
                (
                    '/admin/orders/'+ orderId,
                    {
                        "_token": "{{ csrf_token() }}",
                        "_method": "DELETE",
                    },
                    function(data){
                        if(data === 'SUCCESS'){
                            location.reload();
                        }else{
                            alert(data);
                        }
                    }
                );
            })
        });
    </script>
@endsection