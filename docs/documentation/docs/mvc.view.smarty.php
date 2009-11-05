<p>Во Framy для реализации компонента <code>View</code> используется библиотека Smarty (todo ссылка) с небольшими модификациями.</p>
<p>Доступ к smarty есть в каждом контроллере приложения, посредством свойства <code>smarty</code>. Пример работы со smarty в контроллере:</p>
<<code php>>
$this->smarty->assign('foo', 'bar');
<</code>>
<p>Также, если требуется получить объект smarty не в контроллере, его можно получить из <code>toolkit</code>'а: (todo ссылка)</p>
<<code php>>
$toolkit = systemToolkit::getInstance();
$smarty = $toolkit->getSmarty();
<</code>>