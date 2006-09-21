<?php
function getPaths($array, $path = '') {
    $values = array();

    $i = 1;

    foreach ($array as $key => $value) {
        $p = (empty($path)) ? $i : $path . '.' . $i;

        if(is_array($value)) {
            $values[$p] = $key;
            $values = $values + getPaths($value, $p);
        } else {
            $values[$p] = $value;
        }

        $i++;
    }

    return $values;
}

function render($id) {
    $path = 'docs/' . $id . '.php';
    if(!file_exists($path)) {
        exit;
    }

    $note = '
<div class="note">
<table border="0" summary="note">
<tr>
<td rowspan="2" width="50"><img alt="примечание" src="note.png" width="40" height="49" /></td>
<td><strong>Примечание</strong></td>
</tr>
<tr>
<td valign="top">';


    $note_end = '</td>
</tr>
</table>
</div>
';



    $content = file_get_contents($path);
    $content = preg_replace("/<!--\s*code\s*(\d+)\s*-->/ie", 'include_code("' . $id . '-$1");', $content);
    $content = str_replace(array("<<code>>", "<</code>>"), array("<!-- code start here -->\n<div class=\"code\">\n<code>\n", "\n</code>\n</div>\n<!-- code end here -->\n"), $content);

    $content = str_replace(array('<<note>>', '<</note>>'), array($note, $note_end), $content);
    return $content;
}

function include_code($id) {
    $path = 'codes/' . $id . '.php';
    if(!file_exists($path)) {
        echo "<font color=red>[code for '$id' doesn't exists]</font>";
        exit;
    }
    return '<div class="code">' . highlight_file($path, 1) . '</div>';
}


function checkFile($num) {
    if(!file_exists('docs/' . $num . '.php') || filesize('docs/' . $num . '.php') < 6) {
        touch('docs/' . $num . '.php');
        return ' <font style="color: red;">[todo]</font>';
    } else {
        return '';
    }
}

$menu = array("Предисловие" =>
                        array(
                        "Введение",
                        "Краткое руководство (faq?)",
                        ),
           "Установка и настройка" =>
                        array(
                        "Минимальные требования",
                        "Установка на linux",
                        "Установка на windows",
                        "Конфигурация"
                                => array("Системная конфигурация (? настройка config.php)",
                                         "Настройка Rewrite для URL",
                                         "Описание map (?)"),
                        ),
           "Структура mzz" =>
                        array(
                        "Шаблоны"
                                => array("Общие сведения",
                                         "Функция {load}",
                                         "Функция {add}",
                                         "Функция {url}",
                                         ),
                        "Основные (или все) классы из ./system"
                                => array("Тулкит",
                                         "Request",
                                         "Resolver",
                                         "Dataspace",
                                         "Frontcontroller"
                                         ),
                        "Процесс запуска приложения",
                        "Средства и методы работы с данными",
                        "MVC",
                        "Структура урлов, что какая часть значит",
                        "ОРМ",
                        "Структура каталогов mzz",
                        "Назначение различных файлов (вроде реврайт-мапа итд)",
                        ),
           "Быстрый старт" =>
                        array(
                        "Структура проекта",
                        "Создание конфигурации для проекта",
                        "Использование стандартных модулей",
                        "Расширение модуля News для конкретного проекта",
                        "Пример создания нового модуля (?)",
                        ),
           "Модули системы" =>
                        array(
                        "Описание структуры типичного модуля mzz"
                                => array("Структура каталогов",
                                         "Actions",
                                         "Controllers",
                                         "Mappers",
                                         "Maps",
                                         ),
                        "Описание Simple (надо как то в названии уточнить что от него все остальные отнаследованы) + методика написания новых модулей",
                        "Описание модуля News",
                        "Описание модуля Page",
                        "Описание модуля Timer",
                        ),
           "Пользователи и Права" =>
                        array(
                        "Управление пользователями",
                        "Управление группами",
                        "Управление правами",
                        ),
            );

$_SELF = $_SERVER['PHP_SELF'];
if (!isset($_REQUEST['cat'])) {
    require_once('header.inc.php');
    echo "<strong>Содержание</strong><br />\n<dl>\n";
    $i = 1;
    // Все категории
    foreach ($menu as $title => $items) {
        echo '<dt><a href="' . $_SELF . '?cat=' . $i . '#' . $i . '">' . $i . '. ' . $title . "</a></dt>\n";

        $n = 1;
        // Все подкатегории
        echo '<dd><dl>';
        foreach ($items as $subtitle => $subitem) {
            //
            $num = implode('.', array($i, $n));
            if (is_array($subitem)) {
                $m = 1;
                echo '<dt><a href="' . $_SELF . '?cat=' . $num . '#' . $num . '">' . $num . '. ' . $subtitle . "</a></dt>\n";
                echo '<dd><dl>';
                // Разделы в подкатегориях
                foreach ($subitem as $subsubitem) {
                    $num = implode('.', array($i, $n, $m));
                    echo '<dt><a href="' . $_SELF . '?cat=' . $i . '.' . $n . '#' . $num .'">' . $num . '. ';
                    echo $subsubitem . "</a> " . checkFile($num) . "</dt>\n";

                    $m++;
                }
                echo '</dl></dd>';

            } else {
                echo '<dt><a href="' . $_SELF . '?cat=' . $num . '#' . $num .'">' . $num . '. ' . $subitem . "</a>" . checkFile($num) . "</dt>\n";
            }
            $n++;

        }
        echo '</dl></dd>';

        $i++;
    }
    echo "</dl>\n";
} else {

    $cat = explode(".", $_REQUEST["cat"]);
    $paths = getPaths($menu);

    $tmp = $paths;

    // Очищаем от разделов в субкатегориях
    foreach($tmp as $path => $title) {
        $items = explode(".", $path);
        if(count($items) > 2) {
            unset($tmp[$path]);
        }
    }

    $prev = 1;

    $break = false;
    foreach($tmp as $path => $title) {
        if($break) {
            break;
        }
        if($path == $_REQUEST["cat"]) {
            $break = true;
        } else {
            $prev = $path;
        }
    }
    
    $title = $paths[$_REQUEST['cat']];
    require_once('header.inc.php');

    echo '<div class="navigation"><table width="99%" summary="Navigation">
    <tr>
     <td width="20%" align="left">';
    if($prev != $_REQUEST['cat']) {
        echo '<a href="' . $_SELF . '?cat=' . $prev . '">Назад</a>';
    } else {
        echo 'Назад';
    }
    echo '</td>
       <td width="60%" align="center"><a href="' . $_SELF . '?cat=' . $cat[0] . '">' . $cat[0] . '. ' . $paths[$cat[0]] . '</a></td>
       <td width="20%" align="right">';

    if($path != $_REQUEST['cat']) {
        echo '<a href="' . $_SELF . '?cat=' . $path . '">Вперед</a>';
    } else {
        echo 'Вперед';
    }

    echo '
     </td>
    </tr>
    </table></div>';


    if (isset($cat[1])) {
        $category = $paths[$cat[0]];
        $tmp = $paths[$_REQUEST['cat']];


        echo '<p class="title"><a name="' . $_REQUEST['cat'] . '"></a>' . $_REQUEST['cat'] . ' ' . $paths[$_REQUEST['cat']] . '</p>';
        if (isset($menu[$category][$tmp]) && is_array($menu[$category][$tmp])) {
            $i = 1;
            echo "<dl>";
            foreach($menu[$category][$tmp] as $title => $value) {

                $num = $_REQUEST['cat'];
                echo '<dt><a href="' . $_SELF . '?cat=' . $num . '#' . $num . '.' . $i . '">' . $num . '. ';
                echo (is_array($value)) ? $title : $value;
                echo "</a></dt>\n";
                $i++;
            }
            echo "</dl>";
        }


        if(isset($menu[$category][$tmp]) && is_array($menu[$category][$tmp])) {
            foreach ($menu[$category][$tmp] as $key => $title) {
                $id = $_REQUEST['cat'] . '.' . ($key + 1);
                echo '<div class="subtitle"><a name="' . $id . '"></a>' . $id . ' ' . $title . '</div>';
                echo render($id);
            }
        } else {
            echo render($_REQUEST['cat']);
        }

    } else {
        $tmp = $paths[$cat[0]];
        $i = 1;
        echo "<dl>";
        foreach($menu[$tmp] as $title => $value) {

            $num = $cat[0] . "." . $i;
            echo '<dt><a href="' . $_SELF . '?cat=' . $num . '#' . $num . '">' . $num . '. ';
            echo (is_array($value)) ? $title : $value;
            echo "</a></dt>\n";
            $i++;
        }
        echo "</dl>";
    }



    echo '<div class="navigation_f"><table width="99%" summary="Navigation">
    <tr>
     <td width="20%" align="left" valign="top">';
    if($prev != $_REQUEST['cat']) {
        echo '<a href="' . $_SELF . '?cat=' . $prev . '">Назад</a>';
    } else {
        echo 'Назад';
    }
    echo '</td>
       <td width="60%" align="center"><a href="' . $_SELF . '?cat=' . $cat[0] . '">' . $cat[0] . '. ' . $paths[$cat[0]] . '</a><br /><a href="' . $_SELF . '">Индекс</a></td>
       <td width="20%" align="right" valign="top">';

    if($path != $_REQUEST['cat']) {
        echo '<a href="' . $_SELF . '?cat=' . $path . '">Вперед</a>';
    } else {
        echo 'Вперед';
    }

    echo '
     </td>
    </tr>
    </table></div>';

}
?>
</div>
<br />
</body>
</html>