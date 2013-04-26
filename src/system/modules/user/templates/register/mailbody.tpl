<p>Hello, {$user->getLogin()|h}!</p>
<p>На Ваш e-mail была запрошена регистрация</p>
<p>&nbsp;</p>
<p>Для подтверждения регистрации перейдите по этой ссылке:</p>
<p><a href="{url route="default2" module="user" action="register" _user=$user->getId() _confirm=$confirm escape=true}">{url route="default2" module="user" action="register" _user=$user->getId() _confirm=$confirm escape=true}</a></p>