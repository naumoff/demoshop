@extends('layouts.dashboard-admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar-admin')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Создание партнера</div>
                    <div class="panel-body">
                        <ul class="nav nav-pills nav-justified">
                            <li>
                                <a href="{{route('partners.edit',['part_id'=>$partner->id])}}">
                                    Редактор Партнера
                                </a>
                            </li>
                            <li class="active">
                                <a href="#">Редактор карточек</a>
                            </li>
                        </ul>
                        @include('inclusions.error-message')
                        <form method="post" action="{{route('admin-partner-store-card',['part_id'=>$partner->id])}}">
                            {{csrf_field()}}
                            <input type="text" name="holder-id" value="{{$partner->id}}" hidden>
                            <div class="form-group">
                                <label for="first_name">Имя партнера:</label>
                                <input type="text"
                                       class="form-control"
                                       id="first_name"
                                       placeholder="Введите имя партнера"
                                       required
                                       readonly
                                       name="first-name"
                                       value="{{$partner->first_name}}"
                                >
                            </div>
                            <div class="form-group">
                                <label for="last_name">Фамилия партнера:</label>
                                <input type="text"
                                       class="form-control"
                                       id="last_name"
                                       placeholder="Введите фамилию партнера"
                                       required
                                       readonly
                                       name="last-name"
                                       value="{{$partner->last_name}}"
                                >
                            </div>
                            <div class="form-group">
                                <label for="bank">Банк:</label>
                                <input type="text"
                                       class="form-control"
                                       id="bank"
                                       placeholder="Введите название банка"
                                       required
                                       name="bank"
                                       value="{{old('bank')}}"
                                >
                            </div>
                            <div class="form-group">
                                <label for="card_number">Номер карточки:</label>
                                <input type="text"
                                       class="form-control"
                                       id="card_number"
                                       placeholder="Введите номер карточки"
                                       required
                                       name="card-number"
                                       value="{{old('card-number')}}"
                                >
                            </div>
                            <div class="form-group">
                                <label for="card_limit_eur">Лимит карточки:</label>
                                <input type="text"
                                       class="form-control"
                                       id="card_limit_eur"
                                       placeholder="Ежемесячный лимит на карточку"
                                       required
                                       name="card-limit-eur"
                                       value="{{(old('card-limit-eur')!==null)?old('card-limit-eur'):600}}"
                                >
                            </div>
                            <div class="form-group">
                                <label for="card_limit_eur">Cуммарный лимит по всем активным карточкам:</label>
                                <input type="text"
                                       class="form-control"
                                       id="total-cards-eur"
                                       readonly
                                       name="total-cards-eur"
                                       value="{{$partner->total_cards_eur}}"
                                >
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input
                                            type="checkbox"
                                            name="active"
                                            value=1
                                            {{(old('active')==1)?'checked':null}}
                                    >
                                    Карточка активна
                                </label>
                            </div>
                            <button type="submit" class="btn btn-success">Добавить платежную карту</button>
                        </form>
                        <hr>
                        @if($cards !== null && count($cards) > 0)
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Банк</th>
                                <th>Карточка</th>
                                <th>Лимит</th>
                                <th>Активность</th>
                                <th>Редактор</th>
                                <th>Удалить</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cards AS $card)
                            <tr>
                                <td>{{$card->bank}}</td>
                                <td>{{$card->card_number}}</td>
                                <td>{{$card->card_limit_eur}}</td>
                                <td>{{$card->active}}</td>
                                <td>Редактор</td>
                                <td>Удалить</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                            {{ $cards->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection