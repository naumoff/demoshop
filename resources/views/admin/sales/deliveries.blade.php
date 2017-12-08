@extends('layouts.dashboard-admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar-admin')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Категории</div>
                    <div class="panel-body">
                        @include('inclusions.admin.add-delivery-modal')
                        @if(count($deliveries)>0)
                            @include('inclusions.error-message')
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Минимальный вес</th>
                                    <th>Максимальный вес</th>
                                    <th>Стоимость доставки</th>
                                    <th>Редактор</th>
                                    <th>Удалить</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($deliveries AS $delivery)
                                    <tr>
                                        <td>{{$delivery->min_weight}}</td>
                                        <td>{{$delivery->max_weight}}</td>
                                        <td>{{$delivery->delivery_cost}}</td>
                                        <td>
                                            @include('inclusions.admin.edit-delivery-modal',['delivery'=>$delivery])
                                        </td>
                                        <td>
                                            <button
                                                    type="button"
                                                    class="btn btn-danger btn-xs delete"
                                                    id="{{$delivery->id}}"
                                            >
                                                Удалить
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            {{ $deliveries->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    $(function(){
        $(".delete").click(function(){
            var deliveryId = $(this).attr('id');
            $.post
            (
                '/admin/sales/deliveries/'+deliveryId,
                {
                    "_token": "{{ csrf_token() }}",
                    "_method": "DELETE", // delete
                    'delivery-id':deliveryId
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