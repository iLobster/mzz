<p>Вся конфигурация проекта содержится в следующих файлах в каталоге проекта:</p>
<<code>>
        configs<br />
        |<br />
        |------- <strong>.htaccess</strong><br />
        |<br />
        |------- <strong>routes.php</strong><br />
        |<br />
        <strong>.htaccess</strong><br />
        <strong>application.php</strong><br />
        <strong>config.php</strong><br />
<</code>>

<p>Файл <code>configs/.htaccess</code> содержит лишь одну строку, которая запрещает внешний просмотр и выполнение файлов в каталоге <code>configs/</code></p>
<<code>>
Deny from all
<</code>>

<p>Файл <code>configs/routes.php</code> содержит <a href="doc.php?cat=2.4#2.4.2">настройку Routes для URL</a></p>
<!-- code 1 -->

<p>Файл <code>application.php</code> (todo)</p>
<!-- code 2 -->

<p>Файл <code>.htaccess</code> содержит <a href="doc.php?cat=2.4#2.4.3">настройки для http-сервера Apache</a></p>
<!-- code 3 -->

<p>Файл <code>config.php</code> содержит <a href="doc.php?cat=2.4#2.4.1">системную конфигурацию</a></p>
<!-- code 4 -->
