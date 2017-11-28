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
                                        <a href="/admin/products/{{$categoryItem->id}}/{{$group->id}}/products">
                                            {{$categoryItem->category}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="panel-heading">Группы
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle"
                                    type="button"
                                    data-toggle="dropdown">
                                {{$group->group}}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                @foreach($groups AS $groupItem)
                                    <li>
                                        <a href="/admin/products/{{$category->id}}/{{$groupItem->id}}/products">
                                            {{$groupItem->group}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="panel-heading">
                        Товары <br>
                        <a href="/admin/products/create-product" class="btn btn-success" role="button">Добавить товар</a>
                        @include('inclusions.error-message')
                    </div>
                    <div class="panel-body">
                        @if(count($products)>0)
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Товар</th>
                                    <th>Активность</th>
                                    <th>Товары</th>
                                    <th>Редактор</th>
                                    <th>Удалить</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            {{--{{ $categories->links() }}--}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection