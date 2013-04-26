<ul>
    <li>
        Настройте ваш веб-сервер таким образом, чтобы корень вебсайта указывал на директорию www demo-приложения. Пример конфигурационной директивы для apache:
        <<code apache>>
            DocumentRoot /home/user/demo/www
        <</code>>
    </li>
    <li>
        Установите для веб-сервера права, позволяющие осуществщять запись в директорию tmp demo-приложения.
        <<code bash>>
chown apache:apache -R /home/user/demo/tmp
chmod 755 -R /home/user/demo/tmp
        <</code>>
    </li>
    <li>
        Импортируйте тестовую базу
        <<code bash>>
            mysql -u user -ppassword < /home/user/demo/db/demo.sql
        <</code>>
        <<alert>>В процессе импорта удалятся существующие БД с именами "mzz". Для использования другого имени базы данных отредактируйте в /db/mzz.sql<</alert>>
    </li>
    <li>
        Укажите в файле config.php абсолютный путь до системных библиотек MZZ. Например:
        <<code php>>
            define('SYSTEM_PATH', realpath(dirname(__FILE__) . '/../MZZ/system/'));
        <</code>>
        В приведённом примере MZZ располагается по адресу: <code>/home/user/MZZ</code>
    </li>
    <li>
        Измените в файле config.php параметры подключения к БД demo-приложения, если необходимо. Например:
        <<code php>>
systemConfig::$db['default']['dsn']  = 'mysql:host=localhost;dbname=mzz';
systemConfig::$db['default']['user'] = 'root';
systemConfig::$db['default']['password'] = '';
        <</code>>
    </li>
</ul>

<p>Готово! Теперь demo-приложение доступно по адресу, указанному в настройке виртуального хоста!</p>