<p>Если продукт был загружен с официального сайта mzz (<a href="http://www.mzz.ru">http://www.mzz.ru</a>), то перед установкой необходимо распаковать архив с исходным кодом на локальный сервер.
В UNIX-подобной операционной системе для извлечения содержимого архива в корень веб-сервера (например, htdocs) используется следующий способ:</p>
<<code bash>>
tar -xvzf <имя архива>.tar.gz -C htdocs/
<</code>>


<p>После распаковки проверьте <a href="setup.configuration.html">настройки</a> в файле <code>www/config.php</code> и, если требуется, измените их на ваши.</p>

<p>Если mzz установлен не в корень веб-сервера, то необходимо в <code>SITE_PATH</code> указать URL-путь.</p>

<p>Например, DocumentRoot в конфигурации веб-сервера Apache имеет значение <code>c:\www</code>, mzz распакован в <code>c:\www\sites\mzz</code>. Соответственно URL будет иметь примерно следующий вид: <code>http://localhost/sites/mzz/www/</code>. В таком случае <code>SITE_PATH</code> должен иметь значение <code>/sites/mzz/www</code>, в <code>www/.htaccess</code> изменятся некоторые директивы:
<<code apache>>
#...
RewriteBase /sites/mzz/www
#...
RewriteCond %{REQUEST_URI} !^/sites/mzz/www/?$
#...
RewriteRule (.*) index.php?path=/$1&%{QUERY_STRING} [L]
<</code>>

</p>


<p><strong>Следующий шаг: установка прав доступа на файлы и папки.</strong> С ними не все так просто, универсальных прав не существует. Они зависят от политики безопасности и настроек хостинг-провайдера. Для рабочего сайта права на запись необходимы только директории <code>tmp/</code> и ее содержимому. Во время разработки проекта потребуются права на запись для директорий <code>tests/tmp/</code>, <code>system/modules</code>,  <code>www/modules</code> и их содержимому. Обычно могут подойти права 777 (rwxrwxrwx).</p>

<p>Остальным файлам и папкам требуются только права на чтение, чаще всего подойдут 644 (rw-r--r--) - для файлов, 755 (rwxr-xr-x) - для папок.</p>

<p>Заключительным шагом будет <strong>импорт таблиц и данных в MySQL</strong>, которые хранятся в файлах <code>db/mzz.sql</code> и <code>db/mzz_test.sql</code> (для тестов). Сделать это можно через phpmyadmin или консоль:
<<code bash>>mysql < mzz.sql
mysql < mzz_test.sql<</code>>
</p>

<<note>>В процессе импорта удалятся существующие БД с именами "mzz" и "mzz_test". Для использования другого имени базы данных отредактируйте в /db/mzz.sql или /db/mzz_test.sql имя базы данных в запросах: DROP DATABASE, CREATE DATABASE, USE.<</note>>
<p>На этом установка завершена. Для проверки работоспособности mzz рекомендуется запустить тесты (в нашем примере по URL <code>http://localhost/sites/mzz/tests/run.php</code>).</p>