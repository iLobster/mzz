<p>
Скачайте dummy (пустой) проект с <a href="http://www.framy.ru/download/">Download</a> и распакайте его в любую директорию, которая доступна веб-серверу.
</p>
<p>Структура типичного веб приложения на framy выглядит следующим образом:</p>
<table class="beauty">
    <tr>
        <th>Имя файла</th>
        <th>Описание</th>
    </tr>
    <tr>
        <td>db/</td>
        <td>дампы базы данных приложения</td>
    </tr>
    <tr>
        <td>files/</td>
        <td>файлы, хранимые модулем fileManager</td>
    </tr>
    <tr>
        <td>modules/</td>
        <td>модули приложения</td>
    </tr>
    <tr>
        <td>routes/</td>
        <td>роуты приложения</td>
    </tr>
    <tr>
        <td>templates/</td>
        <td>шаблоны</td>
    </tr>
    <tr>
        <td>tmp/</td>
        <td>временные файлы</td>
    </tr>
    <tr>
        <td>www/</td>
        <td>корневая директория приложения</td>
    </tr>
    <tr>
        <td>application.php</td>
        <td>класс приложения</td>
    </tr>
    <tr>
        <td>config.php</td>
        <td>основная конфигурация приложения</td>
    </tr>
</table>

<p>Корневая директория приложения (www/) - это директория доступная для чтения веб-браузером. В ней хранятся все js/css-файлы, картинки и прочий общедоступный контент. Структура этой директории выглядит так:</p>
<table class="beauty">
    <tr>
        <th>Имя файла</th>
        <th>Описание</th>
    </tr>
    <tr>
        <td>css/</td>
        <td>файлы стилей</td>
    </tr>
    <tr>
        <td>images/</td>
        <td>файлы изображений</td>
    </tr>
    <tr>
        <td>js/</td>
        <td>файлы javascript</td>
    </tr>
    <tr>
        <td>index.php</td>
        <td>точка входа в приложение, именно этому файлу передаётся управление</td>
    </tr>
</table>

<p>Мы установили сам фреймворк в директорию <code>/home/framy</code>, приложение будет установлено в <code>/home/framy/app</code>, веб-сервер настроен на директорию - <code>/home/framy/app/www</code>. Адрес нашего проекта будет <code>http://framy.blog/</code>.
</p>

<p>При необходимости, если фреймворк установлен в отличной от нашего примера директории, в файле <code>config.php</code> можно изменить путь к фреймворку.</p>
<<code php>>
define('SYSTEM_PATH', realpath(dirname(__FILE__) . '/../system/'));
<</code>>

<p>Также включим DEBUG-режим (т.к. мы будем писать новый модуль, нам необходимо видеть все ошибки) в том же файле.</p>
<<code php>>
define('DEBUG_MODE', true);
<</code>>

<div class="note">
    Если вы устанавливаете приложение на Unix-сервере, возможно, понадобится установить права для записи в <code>tmp</code> директорию.
    <p>
        <code>
            chown &lt;user&gt;:&lt;group&gt; -R /home/framy/app/tmp<br />
            chmod 755 -R /home/framy/app/tmp
        </code>
    </p>
    Уточните у вашего системного администратора какие права необходимы чтобы разрешить веб-серверу запись в директорию.
</div>

== configuring_database.Конфигурация базы данных
<p>Откроем <code>db/mzz_dummy.sql</code> и изменим имя базы данных.</p>
<<code mysql>>
/*!40000 DROP DATABASE IF EXISTS `framy_blog`*/;
CREATE DATABASE /*!32312 IF NOT EXISTS*/ `framy_blog` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `framy_blog`;
<</code>>

<p>Импортируем измененный дамп dummy-базы в MySQL:</p>
<<code bash>>
   mysql -u user -ppassword < /home/framy/app/db/mzz_dummy.sql
<</code>>

<p>И изменим настройки базы данных все в том же <code>config.php</code>.</p>
<<code php>>
systemConfig::$db['default']['dsn']  = 'mysql:host=localhost;dbname=framy_blog';
systemConfig::$db['default']['user'] = 'root';
systemConfig::$db['default']['password'] = '';
<</code>>

<p>Если все было сделано правильно и dummy приложение установлено, по адресу http://framy.blog/ мы увидим некоторый hello текст.</p>
<<code text>>
Hello, world!
Привет, мир!

Модуль: dummy
Экшн: hello
<</code>>