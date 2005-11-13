<?php
function _error($msg) {
    $error = "<div style='border: 1px solid black; padding: 3px; background-color: #F0F0F0'><b>".$msg."</b>";
    $error .= "<br>".print_r(debug_backtrace(),1)."</div>";
}

function ErrorHandler($errno, $errstr, $errfile, $errline, $vars)
{
     $errortype = array (
               E_ERROR          => "Error",
               E_WARNING        => "Warning",
               E_PARSE          => "Parsing Error",
               E_NOTICE          => "Notice",
               E_CORE_ERROR      => "Core Error",
               E_CORE_WARNING    => "Core Warning",
               E_COMPILE_ERROR  => "Compile Error",
               E_COMPILE_WARNING => "Compile Warning",
               E_USER_ERROR      => "User Error",
               E_USER_WARNING    => "User Warning",
               E_USER_NOTICE    => "User Notice",
               E_STRICT          => "Runtime Notice"
               );

    if($errno == '2048') return false;

    echo '<table border="0" cellpadding="0" cellspacing="0" width="700" style="border: 1px solid #D1D8DC; background-color: #FBFBFB;">
  <tr>
   <td width="100%" class="error_title">'.$errortype[$errno].'</td>
   <td align="right" class="error_title"><img src="/templates/images/error.gif" width="29" height="36" border="0" alt=""></td>
  </tr>
  <tr>
   <td colspan="2" class="error_content"><b>Обнаружена ошибка при выполнении.</b><br><br>
<b>Debug-mode включен</b>:<br>
File <b>'.$errfile.'</b> [line '.$errline.']: <i>'.$errstr.'</i><br><br>
<b>Конфигурация</b><br>
SAPI: <b>'.php_sapi_name().'</b><br>
Software: <b>'.(!empty($_SERVER["SERVER_SOFTWARE"])?$_SERVER["SERVER_SOFTWARE"]:"unknown").'</b><br>
PHP: <b>'.phpversion().' ('.PHP_OS.', ZendEngine '.zend_version().')</b><br>
Версия CMS: <b>0.0.1-dev</b><br>
 </tr>
</table>';
}
set_error_handler("ErrorHandler");
?>