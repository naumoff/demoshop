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
                            Добавить подарок
                        </a>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Подарок</th>
                                <th>Описание</th>
                                <th>Вес</th>
                                <th>Мин. заказ</th>
                                <th>Макс. заказ</th>
                                <th>Активность</th>
                                <th>Редактор</th>
                                <th>Удалить</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($presents AS $present)
                                <tr>
                                    <td>{{$present->present_ru}}</td>
                                    <td>{{$present->description}}</td>
                                    <td>{{$present->weight_gr}}</td>
                                    <td>{{$present->min_order_value_rub}}</td>
                                    <td>{{$present->max_order_value_rub}}</td>
                                    <td>
                                        <button
                                                type="button"
                                                class="btn btn-sm status"
                                                id="{{$present->id}}"
                                                value="{{$present->active}}"
                                        >
                                            <b>{{ $status=($present->active)?'+':'-' }}</b>
                                        </button>
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-xs"
                                           href="{{route('presents.edit',['id'=>$present->id])}}"
                                           role="button"
                                        >
                                            Редактор
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#"
                                           id="{{$present->id}}"
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
                        {{ $presents->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    $(function(){
        $(".status").click(function(){
            var presentId = $(this).attr('id');
            var oldValue = $(this).attr('value');
            $.post
            (
                '/admin/present/status',
                {
                    "_token": "{{ csrf_token() }}",
                    'present-id':presentId,
                    'old-value':oldValue
                },
                function(data){
                    if(data === 'SUCCESS'){
                        location.reload();
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