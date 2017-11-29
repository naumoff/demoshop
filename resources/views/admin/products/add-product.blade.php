@extends('layouts.dashboard-admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar-admin')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Карточка нового товара</div>
                    <div class="panel-body">
                        <div class="btn-group">
                            Категории
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
                                            <a href="/admin/products/{{$categoryItem->id}}/create-product?group={{$group->id}}">
                                                @if($categoryItem->active == 1)
                                                    <b>{{$categoryItem->category}}</b>
                                                @else
                                                    {{$categoryItem->category}}
                                                @endif
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            @if($categoryActive == 1)
                                Категория активна
                            @else
                                <b style="color: red">Категория не активна</b>
                            @endif
                        </div>
                        <div class="btn-group">
                            Группы
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
                                            <a href="/admin/products/{{$category->id}}/create-product?group={{$groupItem->id}}">
                                                @if($groupItem->active == 1)
                                                    <b>{{$groupItem->group}}</b>
                                                @else
                                                    {{$groupItem->group}}
                                                @endif
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            @if($groupActive == 1)
                                Группа активна
                            @else
                                <b style="color: red">Группа не активна</b>
                            @endif
                        </div>
                        <hr>
                        <form action="/action_page.php">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email"
                                       class="form-control"
                                       id="email"
                                       placeholder="Enter email"
                                       name="email">
                            </div>
                            <div class="form-group">
                                <label for="pwd">Password:</label>
                                <input type="password"
                                       class="form-control"
                                       id="pwd"
                                       placeholder="Enter password"
                                       name="pwd">
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox"
                                              name="remember"> Remember me</label>
                            </div>
                            <button type="submit" class="btn btn-default">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection