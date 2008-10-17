<p>Функция <code>{add}</code> является простым способом включить в шаблон JS и CSS файлы. Если файл уже был включен, второй раз он подключен не будет.
Результатом этих функций являются HTML-теги <code>&lt;script&gt;</code> и <code>&lt;style&gt;</code> (в зависимости от типа подключаемого файла).</p>

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

