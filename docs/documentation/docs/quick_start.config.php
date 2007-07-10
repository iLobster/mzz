<p>Вся конфигурация проекта содержится в следующих файлах в каталоге проекта:</p>
<<code>>
configs/
  .htaccess
  routes.php
.htaccess
application.php
config.php
<</code>>

<p>Файл <code>configs/.htaccess</code> содержит лишь одну строку, которая запрещает внешний просмотр и выполнение файлов в каталоге <code>configs/</code></p>
<<code apache>>
Deny from all
<</code>>

<p>Файл <code>configs/routes.php</code> содержит <a href="doc.php?cat=2.4#2.4.2">настройку Routes для URL</a></p>
<!-- php code 1 -->

<p>Файл <code>application.php</code> (todo)</p>
<!-- php code 2 -->

<p>Файл <code>.htaccess</code> содержит <a href="doc.php?cat=2.4#2.4.3">настройки для http-сервера Apache</a></p>
<!-- apache code 3 -->

<p>Файл <code>config.php</code> содержит <a href="doc.php?cat=2.4#2.4.1">системную конфигурацию</a></p>
<!-- php code 4 -->
