@extends('layouts.dashboard-admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar-admin')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Пакеты</div>
                    <div class="panel-body">
                        <a href="{{route('packages.create')}}" class="btn btn-success" role="button">
                            Добавить пакет
                        </a>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Категория</th>
                                <th>Пакет</th>
                                <th>Стоимость</th>
                                <th>Старт действия пакета</th>
                                <th>Конец действия пакета</th>
                                <th>Активность</th>
                                <th>Редактор</th>
                                <th>Удалить</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($packages AS $package)
                                <tr>
                                    <td>{{$package->category->category}}</td>
                                    <td>{{$package->package_ru}}</td>
                                    <td>
                                        @if($package->price_rub_manual !== null)
                                            {{$package->price_rub_manual}} руб.
                                        @else
                                            {{$package->price_rub_auto}} руб.
                                        @endif
                                    </td>
                                    <td>{{$package->package_start_period}}</td>
                                    <td>{{$package->package_end_period}}</td>
                                    <td>
                                        <button
                                                type="button"
                                                class="btn btn-sm status"
                                                id="{{$package->id}}"
                                                value="{{$package->active}}"
                                        >
                                            <b>{{ $status=($package->active)?'+':'-' }}</b>
                                        </button>
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-xs"
                                           href="{{route('packages.edit',['id'=>$package->id])}}"
                                           role="button"
                                        >
                                            Редактор
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#"
                                           id="{{$package->id}}"
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
                        {{ $packages->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    $(function(){
        $(".status").click(function(){
            var packageId = $(this).attr('id');
            var oldValue = $(this).attr('value');
            $.post
            (
                '/admin/package/status',
                {
                    "_token": "{{ csrf_token() }}",
                    'package-id':packageId,
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
            var packageId = $(this).attr('id');
            $.post
            (
                '/admin/packages/'+ packageId,
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