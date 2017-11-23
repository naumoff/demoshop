@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading">Кабинет</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (Auth::user()->status != config('lists.user_status.approved.en'))
                            <div class="alert alert-danger">
                                <h3>Спасибо за Вашу заявку!</h3>
                                <p>Ваша заявка на регистрацию будет рассмотрена в ближайшее время и Вы получете ответ на Ваш email</p>
                            </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
