<ul>
    <li>
        <code>simple404Controller</code>. Предназначен для вывода стандартной ошибки 404 "Запрашиваемый объект не найден".
        Если вам нужно отобразить 404 ошибку у себя в контроллере - следует использовать примерно такой код:
<<code php>>
$controller = new simple404Controller();
return $controller->run();
<</code>>
        Также существует альтернативный способ передачи управления контроллеру 404 ошибки (todo ссылка на описание forward404):
<<code php>>
$mapper = $this->toolkit->getMapper('news', 'news');
...
$this->forward404($mapper);
<</code>>
        В этом случае будет произведён поиск контроллера <code>news404Controller</code> в директории <code>news/controllers</code>. И в случае, если он будет найден - то будет вызван именно он. В противном случае - также будет вызываться <code>simple404Controller</code>.<br />
        В качестве шаблона для этого контроллера используется файл <code>simple/404.tpl</code>, который вы, конечно же, можете переопределить у себя в проекте (todo ссылка на расширение переопределением)<br />
        Также он автоматически вызывается для адресов, которые не были обработаны ни одним из роутов.
    </li>
</ul>