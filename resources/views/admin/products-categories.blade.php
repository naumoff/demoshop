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
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Категория</th>
                                    <th>Группы</th>
                                    <th>Товары</th>
                                    <th>Переименовать</th>
                                    <th>Удалить</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories AS $category)
                                    <tr>
                                        <td>{{$category['category']}}</td>
                                        <td><button>Группы</button></td>
                                        <td><button>Товары</button></td>
                                        <td><button>Переименовать</button></td>
                                        <td><button>Удалить</button></td>
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
@endsection