<p>Шаблон проектирования MVC (Model-View-Controller) организует и разделяет приложение на три отдельные роли:</p>
<ul>
    <li>Модель - инкапсулирует данные приложения и бизнес логику;</li>
    <li>Вид - извлекает данные из модели и форматирует их для представления клиенту;</li>
    <li>Контроллер - управляет течением приложения, получает входные данные из запроса, и передаёт их модели и отображению.</li>
</ul>
<p>Слой модели представлен в mzz <a href="/structure.orm.html">ORM</a>.</p>
<p>Слой представления использует Smarty в качестве шаблонного движка. Более подробное описание работы со Smarty вы можете найти на <a href="http://smarty.php.net">официальном сайте</a>. </p>
<p>Контроллер -- слой, связывающий модель и представление. Именно в контроллер поступают данные запроса, на основе которых происходит получение нужных данных с помощью модели, и именно в контроллере эти данные в "сыром" виде передаются в шаблон. Контроллер вызывается шаблоном и обрабатывает какое-то определённое действие (action). Рассмотрим типичный контроллер mzz (отображение конкретной новости):</p>
<!-- php code 1 -->
<p>Контроллер в mzz должен быть отнаследован от базового класса <code>simpleController</code> и реализовывать как минимум один метод - <code>getView()</code>. Уровень доступа к этому методу должен быть <code>protected</code>, потому как этот метод запускается автоматически из <code>simpleController</code>, после того как будут произведены необходимые подготовительные действия. Ручной запуск контроллеров рекомендуется делать через метод <code>run()</code> (однако, вероятно, вам это не понадобится делать).</p>
<p>В классе <code>simpleController</code> на стадии инициализации создаются ссылки на следующие объекты:</p>
<ul>
    <li><code>$this->request</code> - ссылка на объект класса <a href="structure.classes.html#structure.classes.request"><code>httpRequest</code></a>, содержит данные текущего запроса.</li>
    <li><code>$this->response</code> - ссылка на объект класса <a href="structure.classes.html#structure.classes.response"><code>httpResponse</code></a>, содержит данные ответа клиенту.</li>
    <li><code>$this->smarty</code> - ссылка на объект <code>Smarty</code>.</li>
    <li><code>$this->toolkit</code> - ссылка на объект класса <a href="structure.classes.html#structure.classes.toolkit"><code>systemToolkit</code></a>, являющийся фабрикой для создания объектов системного характера.</li>
</ul>
<p>Данные, которые возвращает метод <code>getView()</code>, будут добавлены к текущему ответу клиенту.</p>