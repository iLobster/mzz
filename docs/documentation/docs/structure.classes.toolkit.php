<p>Тулкит предназначен для того, чтобы получать необходимыe для работы экземпляры классов. Тулкит является реализацией The Composite Pattern и The Registry Pattern. И в свою очередь его можно назвать своеобразным глобальным хранилищем для различных объектов. В стандартной поставке в состав тулкита (конкретнее - класс stdToolkit) входят следующие методы:</p>
<ul>
    <li><em>getRequest()</em> - Возвращает объект httpRequest</li>
    <li><em>getResponse()</em> - Возвращает объект httpResponse</li>
    <li><em>getSession()</em> - Возвращает объект session</li>
    <li><em>getSmarty()</em> - Возвращает объект mzzSmarty</li>
    <li><em>getRouter($request = null)</em> - Возвращает объект requestRouter</li>
    <li><em>getConfig($section, $module)</em> - Возвращает объект config</li>
    <li><em>getTimer()</em> - Возвращает объект Timer</li>
    <li><em>getAction($module)</em> - Возвращает объект Action для модуля $module</li>
    <li><em>getUser()</em> - Возвращает объект текущего пользователя</li>
    <li><em>getObjectId($name = null)</em> - Возвращает уникальный идентификатор необходимый для <a href="structure.acl.html">ACL</a> (и <a href="structure.acl.html#structure.acl.obj_id">"фейковых" объектов</a> в частности)</li>
    <li><em>getMapper($module, $do, $section)</em> - Возвращает необходимый маппер</li>
    <li><em>getCache()</em> - Возвращает объект для работы с кэшем</li>
    <li><em>getValidator()</em> - Возвращает текущий валидатор</li>
    <li><em>getController()</em> - Возвращает контроллер действия модуля</li>
    <li><em>getLang()</em> - Возвращает идентификатор текущего языка</li>
    <li><em>getLocale()</em> - Возвращает объект текущей локали</li>
    <li><em>getSectionName()</em> - Возвращает имя секции по имени модуля</li>
    <li><em>getModuleName()</em> - Возвращает имя модуля по имени секции</li>
    <li><em>setRequest($request)</em> - Устанавливает объект Request</li>
    <li><em>setResponse($response)</em> - Устанавливает объект Response</li>
    <li><em>setSession($session)</em> - Устанавливает объект Session</li>
    <li><em>setSmarty($smarty)</em> - Устанавливает объект Smarty</li>
    <li><em>setRouter($router)</em> - Устанавливает объект requestRouter</li>
    <li><em>setUser($user)</em> - Устанавливает объект пользователя</li>
    <li><em>setConfig($config)</em> - Устанавливает объект конфигурации</li>
    <li><em>setValidator($validator)</em> - Устанавливает валидатор</li>
    <li><em>setLang()</em> - Устанавливает идентификатор языка</li>
    <li><em>setLocale()</em> - Устанавливает объект локали</li>
</ul>
<p>Более подробную информацию о методах можно посмотреть в тестах, классе <code>stdToolkit</code>.</p>
<p>Для получения инстанции тулкита необходимо воспользоваться следующей конструкцией:</p>
<<code php>>
$toolkit = systemToolkit::getInstance();
<</code>>