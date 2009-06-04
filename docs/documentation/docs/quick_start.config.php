<p>Вся конфигурация проекта содержится в следующих файлах в каталоге проекта:</p>
<<code>>
configs/
    .htaccess
    config.php
    modules.php
    routes.php
.htaccess
application.php

<</code>>

<p>Файл <code>configs/.htaccess</code> содержит лишь одну строку, которая запрещает внешний просмотр и выполнение файлов в каталоге <code>configs/</code></p>
<<code apache>>
Deny from all
<</code>>


<p>Файл <code>configs/config.php</code> содержит <a href="setup.configuration.html#setup.configuration.system">системную конфигурацию</a></p>
<!-- php code 4 -->

<p>Файл <code>configs/modules.php</code> содержит ассоциативный массив связи секция =&gt; модуль</p>
<<code php>>
$modules = array (
    'access' => 'access',
    'admin' => 'admin',
    'comments' => 'comments',
    'config' => 'config',
    'menu' => 'menu',
    'news' => 'news',
    'page' => 'page',
    'captcha' => 'captcha',
    'user' => 'user',
);
<</code>>

<p>Файл <code>configs/routes.php</code> содержит <a href="structure.classes.html#structure.classes.routers">настройку Routes для URL</a></p>
<!-- php code 1 -->

<p>Файл <code>application.php</code> (todo)</p>
<!-- php code 2 -->

<p>Файл <code>.htaccess</code> содержит <a href="setup.configuration.html#setup.configuration.apache">настройки для http-сервера Apache</a></p>
<!-- apache code 3 -->
