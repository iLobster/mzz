<p>Для упрощения процесса разработки базовый класс <code>simpleController</code> предоставляет ряд методов и свойств.</p>

<p>Методы:</p>
<table class="listTable" style="width: 85%;">
    <thead>
        <tr>
            <th>Метод</th>
            <th>Аргументы</th>
            <th>Описание</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>setPager</td>
            <td>
                <ul>
                    <li>
                        <code>mapper $mapper</code> - маппер, к которому будет применена пагинация;
                    </li>
                    <li>
                        <code>[int $per_page = 20]</code> - число элементов на странице;
                    </li>
                    <li>
                        <code>[bool $reverse = false]</code> - выводить записи в обратном порядке;
                    </li>
                    <li>
                        <code>[int $round_items = 2]</code> - число страниц, выводимых слева и справа от текущей.
                    </li>
                </ul>
            </td>
            <td>
                Присоединяет класс пагинации к мапперу, который выбирает данные на страницу. Также в <code>smarty</code> автоматически передаётся инстанция объекта-пейджера с именем <code>$pager</code> (todo ссылка на описание класса), который можно отобразить в произвольном месте.<br />
                Пример использования: Выберем список новостей, по 10 новостей на странице. И отобразим их в обратном порядке:<br />
                <code>newsListController.php:</code>
<<code php>>
$this->setPager($newsFolderMapper, 10, true); // устанавливаем pager
$this->smarty->assign('news', $newsFolderMapper->getItems($newsFolder)); // ищем новости
<</code>>
                <code>list.tpl:</code>
<<code smarty>>
<div class="pages">{$pager->toString()}</div>
<</code>>
            </td>
        </tr>

        <tr>
            <td>fetch</td>
            <td>
                <ul>
                    <li>
                        <code>string $path</code> - имя файла шаблона.
                    </li>
                </ul>
            </td>
            <td>
                Запуск на исполнение указанного шаблона.
<<code php>>
return $this->fetch('news/list.tpl');
<</code>>
            </td>
        </tr>

        <tr>
            <td>redirect</td>
            <td>
                <ul>
                    <li>
                        <code>string $url</code> - адрес, на который будет перенаправлен пользователь;
                    </li>
                    <li>
                        <code>[int $code = 302]</code> - код http-ответа.
                    </li>
                </ul>
            </td>
            <td>
                Перенаправление пользователя по указанному урлу.<br />
                Пример использования: Перенеправление на главную страницу приложения:
<<code php>>
$url = new url('default');
return $this->redirect($url->get());
<</code>>
            </td>
        </tr>

        <tr>
            <td>forward</td>
            <td>
                <ul>
                    <li>
                        <code>string $moduleName</code> - имя модуля;
                    </li>
                    <li>
                        <code>string $actionName</code> - имя действия.
                    </li>
                </ul>
            </td>
            <td>
                Передача управления другому контроллеру.<br />
                Пример использования: Вызов из текущего контроллера действия <code>dashboard</code> модуля <code>admin</code>:
<<code php>>
return $this->forward('admin', 'dashboard');
<</code>>
            </td>
        </tr>
    </tbody>
</table>

<p>Свойства:</p>
<table class="listTable" style="width: 85%;">
    <thead>
        <tr>
            <th>Свойство</th>
            <th>Тип</th>
            <th>Описание</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>$toolkit</td>
            <td>stdToolkit</td>
            <td>
                Объект toolkit (todo ссылка на описание)
<<code php>>
$id = $this->toolkit->getMapper('news', 'news');
<</code>>
            </td>
        </tr>
        <tr>
            <td>$request</td>
            <td>httpRequest</td>
            <td>Объект запроса (todo ссылка на описание)
<<code php>>
$path = $this->request->getString('path');
<</code>>
            </td>
        </tr>
        <tr>
            <td>$response</td>
            <td>httpResponse</td>
            <td>Объект ответа (todo ссылка на описание)
<<code php>>
$this->response->setCookie('cookie_name', 'cookie_data');
<</code>>
            </td>
        </tr>
        <tr>
            <td>$smarty</td>
            <td>mzzSmarty</td>
            <td>Smarty (<a href="mvc.view.html#mvc.view.smarty">подробнее</a>)
<<code php>>
$this->smarty->assign('news', $newsFolderMapper->getItems($newsFolder));
$this->smarty->assign('folderPath', $newsFolder->getTreePath());
<</code>>
            </td>
        </tr>
    </tbody>
</table>