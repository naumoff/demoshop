@extends('layouts.dashboard-admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar-admin')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Категории
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle"
                                    type="button"
                                    data-toggle="dropdown">
                                {{$category->category}}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                @foreach($categories AS $categoryItem)
                                    <li>
                                        <a href="/admin/products/{{$categoryItem->id}}/groups">
                                            {{$categoryItem->category}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="panel-heading">
                        Группы <br>
                        @include('inclusions.admin.add-group-modal',['categories'=>$categories,'category'=>$category])
                        @include('inclusions.error-message')
                    </div>
                    <div class="panel-body">
                        @if(count($groups)>0)
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Группа</th>
                                    <th>Активность</th>
                                    <th>Товары</th>
                                    <th>Редактор</th>
                                    <th>Удалить</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($groups AS $group)
                                    <tr>
                                        <td>{{$group['group']}}</td>
                                        <td>
                                            <button
                                                    type="button"
                                                    class="btn btn-sm status"
                                                    id="{{$group->id}}"
                                                    value="{{$group->active}}"
                                            >
                                                <b>{{ $status=($group->active)?'+':'-' }}</b>
                                            </button>
                                        </td>
                                        <td>
                                            <a href="/admin/products/{{$category['id']}}/{{$group['id']}}/products"
                                               class="btn btn-info btn-sm">
                                                Товары
                                                <span class="badge">{{count($group->products)}}</span>
                                            </a>
                                        </td>
                                        <td>
                                            @include('inclusions.admin.edit-group-modal',
                                                [
                                                    'categories'=>$categories,
                                                    'category'=>$category,
                                                    'groups'=>$groups
                                                ]
                                            )
                                        </td>
                                        <td>
                                            <button
                                                    type="button"
                                                    class="btn btn-danger btn-sm delete"
                                                    id="{{$group->id}}"
                                            >
                                                Удалить
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{--{{ $categories->links() }}--}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function(){
            $(".status").click(function(){
                var groupId = $(this).attr('id');
                var oldValue = $(this).attr('value');
                $.post
                (
                    '/admin/group/status',
                    {
                        "_token": "{{ csrf_token() }}",
                        'group-id':groupId,
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
                var groupId = $(this).attr('id');
                $.post
                (
                    '/admin/group/delete',
                    {
                        "_token": "{{ csrf_token() }}",
                        'group-id':groupId
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