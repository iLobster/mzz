<p>Все блоки комментариев должны быть совместимы с форматом phpDocumentor. Для получения дополнительной информации смотрите: <a href="http://phpdoc.org/">http://phpdoc.org/</a></p>

<p>Подходят комментарии в стилях C (/* */) и C++ (//). Первые используются в определении классов, методов, функций и т.д., а вторые внутри методов, функций и в глобальной видимости. Использование комментариев в стиле Perl/shell (#) не допускается.</p>

<p>Все PHP-файлы должны содержать минимальный блок комментариев в качестве заголовка:</p>
<<code php>>
/**
 * &#036;URL&#036;
 *
 * MZZ Content Management System (c) 2005-2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version &#036;Id&#036;
 */
<</code>>