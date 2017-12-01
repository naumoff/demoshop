@extends('layouts.dashboard-admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar-admin')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Редактор курса валют</div>
                    <div class="panel-body">
                        @include('inclusions.error-message')
                        <form class="form-inline" method="post" action="/admin/products/currency-rates">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="currency-rate">Текущий курс EUR/RUB:</label>
                                <input type="number"
                                       class="form-control"
                                       id="currency-rate"
                                       placeholder="Текущий курс EUR/RUB"
                                       value="{{$currentRate}}"
                                       name="eur-rub"
                                       min="1"
                                       max="10000"
                                       step="0.0001"
                                       required
                                >
                            </div>
                            <button type="submit"
                                    class="btn btn-default">Пересчитать стоимость товаров по новому курсу</button>
                        </form>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Курс EUR/RUB</th>
                                <th>Создан</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($allRates AS $rate)
                                    <tr>
                                        <td>{{$rate->eur_rub}}</td>
                                        <td>{{$rate->created_at}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $allRates->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection