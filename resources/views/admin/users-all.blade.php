@extends('layouts.dashboard-admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar-admin')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Все пользователи</div>
                    <div class="panel-body">
                        Admin
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection