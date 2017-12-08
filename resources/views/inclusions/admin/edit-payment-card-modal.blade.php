{{--BUTTON TO OPEN ADD NEW CATEGORY MODAL--}}
<button class="btn btn-success btn-xs"
        type="button"
        data-toggle="modal"
        data-target="#editCard-{{$card->id}}">
    Редактор
</button>
{{--END OF BUTTOM TO OPEN ADD NEW CATEGORY MODAL--}}

{{--ADD NEW CATEGORY MODAL--}}
<div id="editCard-{{$card->id}}" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Изменить банковскую карточку</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('admin-partner-update-card',['PaymentCard'=>$card->id])}}">
                    {{csrf_field()}}
                    {{method_field('PATCH')}}
                    <div class="form-group">
                        <input type="text" name="id" value="{{$card->id}}" hidden>
                        <label for="new-category">
                            Банк:
                        </label>
                        <input
                                type="text"
                                class="form-control"
                                name="bank"
                                value="{{$card->bank}}"
                        >
                        <label for="new-category">
                            Номер карточки:
                        </label>
                        <input
                                type="text"
                                class="form-control"
                                name="card-number"
                                value="{{$card->card_number}}"
                        >
                        <label for="new-category">
                            Ежемесячный лимит (EUR):
                        </label>
                        <input
                                type="text"
                                class="form-control"
                                name="card-limit-eur"
                                value="{{$card->card_limit_eur}}"
                        >
                        <div class="checkbox">
                            <label>
                                <input
                                        type="checkbox"
                                        name="active"
                                        value="1"
                                        {{($card->active == 1)?'checked':null}}
                                >
                                Карточка активная:
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Изменить</button>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" type="button" data-dismiss="modal">
                    Закрыть
                </button>
            </div>
        </div>
    </div>
</div>
{{--END OF ADD NEW CATEGORY MODAL--}}