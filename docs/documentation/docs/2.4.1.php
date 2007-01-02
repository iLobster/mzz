<p>Конфигурация mzz начинается с файла <code>config.php</code> в папке проекта. При необходимости можно изменить необходимые опции.</p>
<p>Описание опций:</p>

<center>
<div class="options_name">SYSTEM_PATH <span class="options_value">= ../system/</span></div>
<div class="options_desc">Путь до mzz. Возможно указание как относительного, так и абсолютного пути</div>

<div class="options_name">DEBUG_MODE <span class="options_value">= true</span></div>
<div class="options_desc">Включение/отключение debug-режима. Возможные варианты: <code>true</code> или <code>false</code>. Если указано 'true',
 то ошибки интерпретатора и внутренние ошибки mzz будут отображены непосредственно в браузер.
 <<note>>Используйте debug режим только в процессе разработки сайта, в готовых проектах это опция должна быть отключена (false),
 так как в текстах ошибок может содержаться конфиденциальная информация<</note>>
</div>

<div class="options_name">MZZ_USER_GUEST_ID <span class="options_value">= 1</span></div>
<div class="options_desc">Идентификатор записи в Базе Данных для неавторизированных пользователей. Изменение требуется при наличии
 базы данных в которой уже есть пользователь с идентификатором установленным по умолчанию. 
 <<note>>Пользователь с указанным идентификатором в константе <code>MZZ_USER_GUEST_ID</code> должен существовать<</note>>
</div>

<div class="options_name">systemConfig::$db['default']['driver'] <span class="options_value">= PDO</span></div>
<div class="options_desc">Драйвер для работы с БД.</div>

<div class="options_name">systemConfig::$db['default']['dsn'] <span class="options_value">= mysql:host=localhost;dbname=mzz</span></div>
<div class="options_desc">DSN, содержит необходимую информацию о базе данных. Более подробно в разделе [todo]</div>

<div class="options_name">systemConfig::$db['default']['user'] <span class="options_value">= root</span></div>
<div class="options_desc">Имя пользователя для доступа к БД, указанной в DNS</div>

<div class="options_name">systemConfig::$db['default']['password'] <span class="options_value">= null</span></div>
<div class="options_desc">Пароль для доступа к БД, указанной в DNS</div>

<div class="options_name">systemConfig::$db['default']['charset'] <span class="options_value">= cp1251</span></div>
<div class="options_desc">Кодировка БД. После успешного соединения с БД выполняется запрос: <code>SET NAMES `кодировка`</code></div>

<div class="options_name">systemConfig::$db['default']['pdoOptions'] <span class="options_value">= array()</span></div>
<div class="options_desc">Дополнительные опции соединения с БД для PDO. Более подробная информация доступна в <a href="http://www.php.net/manual/ref.pdo.php">руководстве по PHP</a></div>


</center>

