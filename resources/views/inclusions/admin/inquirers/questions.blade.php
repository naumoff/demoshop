<table class="table table-striped">
    <thead>
        <tr>
            <th class="col-md-6">Вопрос</th>
            <th class="col-md-6 text-center">Ответы</th>
        </tr>
    </thead>
    <tbody>
        @foreach($questions AS $question)
        <tr>
            <td>
                {{$question->question}}
            </td>
            <td>
                <a
                        href="{{route('admin-show-answers-to-question',['inquirer'=>$question->inquirer->id])}}"
                        class="btn btn-info btn-xs btn-block"
                        role="button"
                >
                    Ответы
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>