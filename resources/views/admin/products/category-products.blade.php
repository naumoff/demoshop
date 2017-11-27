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

                    <div class="panel-heading">Группы</div>
                    <div class="panel-body">
                        @if(count($products)>0)
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Группа</th>
                                    <th>Товар</th>
                                    <th>Активность</th>
                                    <th>Редактировать</th>
                                    <th>Удалить</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products AS $product)
                                    <tr>
                                        <td>{{$product->group->group}}</td>
                                        <td>{{$product->product_ru}}</td>
                                        <td><a href="#" class="btn btn-info">Активировать</a></td>
                                        <td><a href="#" class="btn btn-info">Редактивароть</a></td>
                                        <td><button>Удалить</button></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $products->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection