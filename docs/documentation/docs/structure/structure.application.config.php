<p>Конфигурационный файл демо-приложения (todo: ссылка на скачивание демки)</p>
<<code php>>
<?php
/**
 * Абсолютный путь до сайта.
 * Если mzz установлен в корень веб-сервера, оставьте поле пустым
 * Правильно: /mzz, /new/site
 * Неправильно: site1, site1/, /site1/
 *
 */
define('SITE_PATH', '');
define('COOKIE_DOMAIN', '');

define('DEBUG_MODE', true);
define('SYSTEM_PATH', realpath(dirname(__FILE__) . '/../system/'));

/**
 * Идентификатор записи в БД для неавторизированных пользователей
 */
define('MZZ_USER_GUEST_ID', 1);

/**
 * Идентификатор группы, для которой ACL всегда будет возвращать true (т.е. предоставит полный доступ)
 */
define('MZZ_ROOT_GID', 3);

require_once SYSTEM_PATH . DIRECTORY_SEPARATOR . 'systemConfig.php';

// дефолтный язык приложения
systemConfig::$i18n = 'ru';

// включаем мультиязычность
systemConfig::$i18nEnable = true;

// устанавливаем дефолтную кодировку для выдачи
ini_set('default_charset', 'utf-8');

systemConfig::$db['default']['driver'] = 'pdo';
systemConfig::$db['default']['dsn']  = 'mysql:host=localhost;dbname=mzz';
systemConfig::$db['default']['user'] = 'root';
systemConfig::$db['default']['password'] = '';
systemConfig::$db['default']['charset'] = 'utf8';
systemConfig::$db['default']['options'] = array();

systemConfig::$appName = 'demo';
systemConfig::$appVersion = '1.0-alpha';
systemConfig::$pathToApplication = dirname(__FILE__);
systemConfig::$pathToWebRoot = systemConfig::$pathToApplication . '/www';
systemConfig::$pathToTemp = realpath(dirname(__FILE__) . '/tmp');
systemConfig::$pathToConf = dirname(__FILE__);

systemConfig::$mailer['default']['backend'] = 'PHPMailer';
systemConfig::$mailer['default']['params'] = array('html' => true, 'smtp' => true, 'smtp_host' => 'localhost');

systemConfig::init();

?>
<</code>>

<p>Обо всем по порядку:</p>
<table class="listTable" style="width: 85%;">
    <thead>
        <tr>
            <th>Директива</th>
            <th>Описание</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><<code php>>define('DEBUG_MODE', ...);<</code>></td>
            <td>Режим отладки</td>
        </tr>
        <tr>
            <td><<code php>>define('SYSTEM_PATH', ...));<</code>></td>
            <td>Абсолютный (todo: точно только абсолютный?) путь до <code>system</code> каталога приложения</td>
        </tr>
        <tr>
            <td>
<<code php>>
systemConfig::$appName
systemConfig::$appVersion
<</code>>
            </td>
            <td>Имя и версия вашего приложения. (todo: зер, опиши, где это используется. Только в кешировании?)</td>
        </tr>
        <tr>
            <td><<code php>>systemConfig::$pathToApplication<</code>></td>
            <td>Путь до каталога вашего приложения.</td>
        </tr>
        <tr>
            <td><<code php>>systemConfig::$pathToWebRoot<</code>></td>
            <td>Путь до web-root вашего приложения.</td>
        </tr>
        <tr>
            <td><<code php>>systemConfig::$pathToTemp<</code>></td>
            <td>Путь до tmp каталога</td>
        </tr>
        <tr>
            <td><<code php>>systemConfig::$pathToConf<</code>></td>
            <td>Путь до каталога с конфигурационными файлами приложения</td>
        </tr>
    </tbody>
</table>