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
                        <code>$mapper</code> (mapper) - маппер, к которому будет применена пагинация;
                    </li>
                    <li>
                        <code>$per_page</code> (int, необязательный, значение по умолчанию: 20) - число элементов на странице;
                    </li>
                    <li>
                        <code>$reverse</code> (bool, необязательный, значение по умолчанию: false) - выводить записи в обратном порядке;
                    </li>
                    <li>
                        <code>$round_items</code> (integer, необязательный, значение по умолчанию: 2) - число страниц, выводимых слева и справа от текущей.
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
    </tbody>
</table>