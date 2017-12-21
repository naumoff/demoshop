<table class="table table-striped">
    <thead>
    <tr>
        <th class="col-md-6">Пользователь</th>
        <th class="col-md-6 text-center">Ответы</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users AS $user)
        <tr>
            <td>
                {{$user->first_name}} {{$user->last_name}}
            </td>
            <td>
                <a
                        href="{{route('admin-show-user-answers-to-inquirer',[
                            'inquirer'=>$inquirer->id,
                            'user'=>$user->id
                        ])}}"
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
