<p>Для вставки адреса (URL) в шаблон можно использовать функцию <code>{url}</code>. Результатом работы этой функции является сгенерированный URL, который состоит из:
<dl>
 <dd>- текущего протокола (HTTP/HTTPS);</dd>
 <dd>- адреса HTTP-хоста (HTTP_HOST);</dd>
 <dd>- порта сервера, если используется не 80 порт;</dd>
 <dd>- дополнительного пути, который указан в конфигурационной константе SITE_PATH;</dd>
 <dd>- секции;</dd>
 <dd>- параметров, если они были указаны;</dd>
 <dd>- действия;</dd>
</dl></p>
<p>Для получения текущего URL вызывается <code>{url}</code> без каких-либо аргументов.</p>

<p>Синтаксис функции:</p>
<<code smarty>>
{url section="секция" action="действие" route="имя"}
<</code>>
<p>Описание аргументов:
<dl>
        <dd>- <em>section</em>: имя секции, на которую будет ссылаться URL. Если не указана, будет использована текущая;</dd>
        <dd>- <em>action</em>: действие для указанного section;</dd>
        <dd>- <em>route</em>: имя правила для маршрутизации сборки URL.</dd>
</dl></p>
</p>Все аргументы являются не обязательными.</p>
<p>Функция может принимать так же и любые другие аргументы, которые будут являться параметрами.
Примером генерации http://example.com/news/4/asc/edit в соответствии с правилом маршрутизации <code>:section/:id/:sort/:action</code> является:
</p>
<<code smarty>>
{url section="news" action="edit" id="4" sort="asc" route="newsList"}
<</code>>

<p>Пример генерации URL для редактирования объекта с ID 4 в секции "news" (http://example.com/news/4/edit):</p>
<<code smarty>>
{url section="news" action="edit" id="4"}
<</code>>
<<note>>
Функция генерирует только URL. Например, сделать ее ссылкой можно следующим образом: <code>&lt;a href="{url}"&gt;link&lt;/a&gt;</code>
<</note>>

<p>Редко, но возникает ситуация, когда требуется также передать и обычные GET параметры. Сделать это можно так:</p>
<<code html>>
<a href="{url}?param=value&param2=value2">link</a>
<</code>>