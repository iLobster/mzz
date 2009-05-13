<p>Функция <code>{add}</code> является простым способом включить в шаблон JS и CSS файлы. Если файл уже был включен, второй раз он подключен не будет.
Результатом этих функций являются HTML-теги <code>&lt;script&gt;</code> или <code>&lt;style&gt;</code> (в зависимости от типа подключаемого файла).</p>

<p>Синтаксис функции:</p>
<<code smarty>>
    {add file="имя файла"[ tpl="имя шаблона"]}
<</code>>

<p>Описание аргументов:</p>
<dl>
        <dd>- <em>file</em>: имя подключаемого файла;</dd>
        <dd>- <em>tpl</em>: имя шаблона, определяющий как будет выглядеть результат (по умолчанию это в зависимости от расширения файла <code>js.tpl</code> или <code>css.tpl</code>)</dd>
</dl>

<p><strong>Пример 1.</strong> Подключение CSS и JS файла:</p>
<<code smarty>>
{add file="style.css"}
{add file="style.js"}
<</code>>

<p><strong>Пример 2.</strong> Подключение JS файла, используя специальный шаблон "some_template.tpl":</p>
<<code smarty>>
{add file="script.js" tpl="some_template.tpl"}
<</code>>

<p>Для вывода результата в необходимом месте шаблона (например, header.tpl) размещается код, который включит в шаблон все добавленные ранее файлы:</p>
<<code smarty>>
...
<head>
<title>mzz</title>
{include file='include.css.tpl'}
{include file='include.js.tpl'}
</head>
...
<</code>>

<p>
    Также в mzz имеется возможность включения «склеенных» файлов.
    Благодаря этому для получения нескольких JS или CSS файлов будет выполнен лишь один запрос к web-серверу, что благоприятно скажется на работоспособности.
    Для этого достаточно просто изменить шаблон вывода следующим образом:
</p>
<<code smarty>>
...
<head>
<title>mzz</title>
{include file='include.external.css.tpl'}
{include file='include.external.js.tpl'}
</head>
...
<</code>>

<p>Тогда шаблон вида</p>
<<code smarty>>
{add file="file1.js"}
{add file="file2.js"}
{add file="file3.js"}
{add file="file4.css"}
{add file="file5.css"}
<</code>>

<p>в конечном результате будет выглядеть следующим образом:</p>
<<code smarty>>
<link rel="stylesheet" type="text/css" href="/templates/external.php?type=css&amp;files=file4.css,file5.css" />
<script type="text/javascript" src="/templates/external.php?type=js&amp;files=file1.js,file2.js,file3.js"></script>
<</code>>

<p>Следует отметить, что ввиду некоторых обстоятельств, не все JS и CSS файлы будут работать корректно в «склееном» виде. Поэтому
существует возможность явно запретить файлу участвовать в склеивании. Для этого достаточно передать параметр join=false к аргументам функции:</p>
<<code smarty>>
    {add file="file1.js" join=false}
<</code>>