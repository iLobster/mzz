<p>Класс <code>pager</code> предназначен для постраничного вывода коллекций объектов. Он автоматически получает из запроса номер текущей страницы, и также автоматически добавляет в запрос LIMIT с нужными параметрами. Приведём прототип конструктора пейджера:</p>
<<code php>>
    public function __construct($baseurl, $page, $perPage, $roundItems = 2, $reverse = false)
<</code>>
<ul>
    <li><code>$baseurl</code> - базовый урл, тот урл, на который будут ссылаться страницы пейджера. Переменная page в эту ссылку подставляется автоматически.</li>
    <li><code>$page</code> - номер текущей страницы.</li>
    <li><code>$perPage</code> - число элементов на странице.</li>
    <li><code>$roundItems</code> - число номеров страниц, выводимых вокруг текущего номера.</li>
    <li><code>$reverse</code> - обратная нумерация.</li>
</ul>
<p>Для использования пейджера — необходимо подключить <a href="structure.orm.html#structure.orm.plugins">плагин</a> pagerPlugin к мапперу, который будет получать коллекцию:</p>
<<code php>>
fileLoader::load('modules/pager/plugins/pagerPlugin');
$pager = new pager('/news', 10, 10);
$mapper->attach(new pagerPlugin($pager));
$newsArray = $newsMapper->searchAll();
<</code>>
<p>Для упрощения процесса добавления пейджера, в класс <a href="modules.simple.html#modules.simple.simpleController"><code>simpleController</code></a> добавлен специальный метод <code>setPager</code>:</p>
<!-- php code 1 -->
<p>Как видно из реализации - для установки пейджера достаточно лишь передать маппер, который будет извлекать данные. Пример использования этого метода (класс <code>newsListController</code>:</p>
<!-- php code 2 -->
<p>После этого - нужно передать пейджер в шаблон, в случае если пейджер устанавливается вручную. Если пейджер устанавливается методом <code>simpleController</code>'а, то этого делать не нужно. Затем в шаблоне следует расположить следующий код:</p>
<<code smarty>>
    {$pager->toString()}
<</code>>
<p>Это выведет в нужном месте пейджер. Сам шаблон пейджера находится в <code>www/templates/pager.tpl</code>, естественно изменять его вы можете как вам требуется:</p>
<!-- smarty code 3 -->