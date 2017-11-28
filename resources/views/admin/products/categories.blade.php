@extends('layouts.dashboard-admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar-admin')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Категории</div>
                    <div class="panel-body">
                        @if(count($categories)>0)
                            @include('inclusions.admin.add-category-modal')
                            @include('inclusions.error-message')
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Категория</th>
                                    <th>Активность</th>
                                    <th>Группы</th>
                                    <th>Товары</th>
                                    <th>Редактор</th>
                                    <th>Удалить</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories AS $category)
                                    <tr>
                                        <td>{{$category['category']}}</td>
                                        <td>
                                            <button
                                                    type="button"
                                                    class="btn btn-sm status"
                                                    id="{{$category->id}}"
                                                    value="{{$category->active}}"
                                            >
                                                <b>{{ $status=($category->active)?'+':'-' }}</b>
                                            </button>
                                        </td>
                                        <td>
                                            <a href="/admin/products/{{$category['id']}}/groups"
                                               class="btn btn-info btn-sm">
                                                Группы
                                                <span class="badge">{{count($category->groups)}}</span>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="/admin/products/{{$category['id']}}/products"
                                               class="btn btn-info btn-sm">
                                                Товары
                                                <span class="badge">{{count($category->products)}}</span>
                                            </a>
                                        </td>
                                        <td>
                                            @include('inclusions.admin.edit-category-modal',['category'=>$category])
                                        </td>
                                        <td>
                                            <button
                                                    type="button"
                                                    class="btn btn-danger btn-sm delete"
                                                    id="{{$category->id}}"
                                            >
                                                Удалить
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            {{ $categories->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    $(function(){
        $(".status").click(function(){
            var categoryId = $(this).attr('id');
            var oldValue = $(this).attr('value');
            $.post
            (
                '/admin/category/status',
                {
                    "_token": "{{ csrf_token() }}",
                    'category-id':categoryId,
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
            var categoryId = $(this).attr('id');
            $.post
            (
                '/admin/category/delete',
                {
                    "_token": "{{ csrf_token() }}",
                    'category-id':categoryId
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