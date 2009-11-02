<ul>
    <li>
        Распакуйте архив в директорию с вашими веб-приложениями
        <<code bash>>
            tar -xvzf <archive>.tar.gz -C /home/user
        <</code>>
    </li>
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
    </li>
    <li>
        Укажите в файле config.php абсолютный путь до системных библиотек framy. Например:
        <<code php>>
            define('SYSTEM_PATH', realpath(dirname(__FILE__) . '/../framy/system/'));
        <</code>>
        В приведённом примере framy располагается по адресу: <code>/home/user/framy</code>
    </li>
</ul>

<p>Готово! Теперь demo-приложение доступно по адресу, указанному в настройке виртуального-хоста!</p>