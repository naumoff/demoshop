@extends('layouts.dashboard-admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar-admin')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Подарки</div>
                    <div class="panel-body">
                        <a href="{{route('presents.create')}}" class="btn btn-success" role="button">
                            Добавить партнера
                        </a>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Фамилия</th>
                                <th>Имя</th>
                                <th>Лимит</th>
                                <th>Активность</th>
                                <th>Отложен</th>
                                <th>Карточки</th>
                                <th>Редактор</th>
                                <th>Удалить</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($partners AS $partner)
                                <tr>
                                    <td>{{$partner->first_name}}</td>
                                    <td>{{$partner->last_name}}</td>
                                    <td>{{$partner->total_limit_eur}}</td>
                                    <td>
                                        <button
                                                type="button"
                                                class="btn btn-sm active"
                                                id="{{$partner->id}}"
                                                value="{{$partner->active}}"
                                        >
                                            <b>{{ $status=($partner->active)?'+':'-' }}</b>
                                        </button>
                                    </td>
                                    <td>
                                        <button
                                                type="button"
                                                class="btn btn-sm suspend"
                                                id="{{$partner->id}}"
                                                value="{{$partner->suspended}}"
                                        >
                                            <b>{{ $status=($partner->suspended)?'+':'-' }}</b>
                                        </button>
                                    </td>

                                    <td>
                                        <a class="btn btn-info btn-xs"
                                           href="#"
                                           id="{{$partner->id}}"
                                           role="button"
                                        >
                                            Карточки
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-xs"
                                           href="#"
                                           id="{{$partner->id}}"
                                           role="button"
                                        >
                                            Редактор
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#"
                                           id="{{$partner->id}}"
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
                        {{ $partners->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    $(function(){
        $(".active").click(function(){
            var partnerId = $(this).attr('id');
            var oldValue = $(this).attr('value');
            $.post
            (
                '/admin/partner/active',
                {
                    "_token": "{{csrf_token()}}",
                    "_method": "PATCH",
                    'partner-id':partnerId,
                    'old-value':oldValue
                },
                function(data){
                    if(data === 'SUCCESS'){
                        location.reload();
                    }else{
                        alert(data);
                    }
                }
            );
        });
        $(".delete").click(function(){
            var presentId = $(this).attr('id');
            $.post
            (
                '/admin/presents/'+ presentId,
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