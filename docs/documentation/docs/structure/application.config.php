<p>Типичный конфигурационный файл (config.php):</p>
<<code php>>
<?php
/**
 * Абсолютный путь до сайта.
 * Если mzz установлен в корень веб-сервера, оставьте поле пустым
 * Правильно: /mzz, /new/site
 * Неправильно: site1, site1/, /site1/
 */
define('SITE_PATH', '');
define('COOKIE_DOMAIN', '');

define('DEBUG_MODE', true);

// Путь до директории system в mzz
define('SYSTEM_PATH', realpath(dirname(__FILE__) . '/../system/'));

// Идентификатор записи в БД для неавторизированных пользователей
define('MZZ_USER_GUEST_ID', 1);

// Идентификатор группы, для которой ACL всегда будет возвращать true (т.е. предоставит полный доступ)
define('MZZ_ROOT_GID', 3);

require_once SYSTEM_PATH . DIRECTORY_SEPARATOR . 'systemConfig.php';

// Дефолтный язык приложения
systemConfig::$i18n = 'ru';

// Включаем мультиязычность
systemConfig::$i18nEnable = true;

// Устанавливаем дефолтную кодировку для выдачи
ini_set('default_charset', 'utf-8');

// Настройка соединения с БД приложения
systemConfig::$db['default']['driver'] = 'pdo';
systemConfig::$db['default']['dsn']  = 'mysql:host=localhost;dbname=mzz';
systemConfig::$db['default']['user'] = 'root';
systemConfig::$db['default']['password'] = '';
systemConfig::$db['default']['options'] = array();
systemConfig::$db['default']['options']['init_query'] = 'SET NAMES utf8';

// Установка переменных окружения
systemConfig::$appName = 'demo';
systemConfig::$appVersion = '1.0-alpha';
systemConfig::$enabledModules = array('captcha', 'comments', 'fileManager', 'menu', 'news', 'page');
systemConfig::$pathToApplication = dirname(__FILE__);
systemConfig::$pathToWebRoot = systemConfig::$pathToApplication . '/www';
systemConfig::$pathToTemp = systemConfig::$pathToApplication . '/tmp';
systemConfig::$pathToConfigs = systemConfig::$pathToApplication . '/configs';

// Настройка дефолтного мейлера
systemConfig::$mailer['default']['backend'] = 'PHPMailer';
systemConfig::$mailer['default']['params'] = array('html' => true, 'smtp' => true, 'smtp_host' => 'localhost');

/**
 * Здесь могут находиться другие системные настройки приложения, 
 * такие как настройки кеширования, шаблонизатора, сессий и др.
 */

systemConfig::init();

?>
<</code>>

<p>Опишем параметры конфигурационного файла:</p>
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
            <td>Режим отладки.</td>
        </tr>
        <tr>
            <td><<code php>>define('SYSTEM_PATH', ...));<</code>></td>
            <td>Абсолютный путь до <code>system</code> каталога MZZ.</td>
        </tr>
        <tr>
            <td>
<<code php>>
systemConfig::$appName
systemConfig::$appVersion
<</code>>
            </td>
            <td>Имя и версия вашего приложения.</td>
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
            <td>Путь до tmp каталога приложения.</td>
        </tr>
        <tr>
            <td><<code php>>systemConfig::$pathToConf<</code>></td>
            <td>Путь до каталога с конфигурационными файлами приложения.</td>
        </tr>
    </tbody>
</table>