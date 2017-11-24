@component('mail::message')
# Подтверждение регистрации

Добрый день {{$userName}}!

Поздравляем, Вы получили регистрацию на ресурсе {{$_ENV['APP_NAME']}}!

Для входа на сайт высылаем Ваш логин и пароль:<br>
Логин: {{$login}} <br>
Пароль: {{$password}} <br>

@component('mail::button', ['url' => $url])
Авторизация на сайте
@endcomponent

С уважением,<br>
{{ config('app.name') }}
@endcomponent
