@component('mail::message')
# Отзыв регистрации

Уважаемый {{$userName}},

Ваша регистрация на ресурсе {{$_ENV['APP_NAME']}} отозвана.

Причиной отзыва регистрации является:<br>
{{$reason}}<br>

Пожалуйста, свяжитесь с администрацией нашего ресурса, для восстановления Вашей регистрации.

С уважением,<br>
{{ config('app.name') }}
@endcomponent
