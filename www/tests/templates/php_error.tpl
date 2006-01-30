<br>
<table border="0" cellpadding="0" cellspacing="0" width="700" style="border: 1px solid #D1D8DC; background-color: #FBFBFB;">
  <tr>
   <td width="100%" style="background-color: #C46666; border-top: 1px solid white; padding-right: 10px; padding-left: 10px; font-family: tahoma, verdana, arial; font-size: 14px; color: white; font-weight: bold;">{$errortype.$errno}</td>
   <td align="right" style="background-color: #C46666; border-top: 1px solid white; padding-right: 10px;"><img src="/templates/images/error.gif" width="29" height="36" border="0" alt=""></td>
  </tr>
  <tr>
   <td colspan="2" style="font-family: tahoma, verdana, arial; font-size: 12px; color: #393939; padding: 8px;"><b>Обнаружена ошибка при выполнении.</b><br><br>
        {if $smarty.const.DEBUG_MODE eq true}
            <b>Debug-mode включен</b>:<br>
            File <b>{$errfile}</b> [line {$errline}]: <i>{$errstr}</i><br><br>
            <b>Конфигурация</b><br>
            SAPI: <b>{$sapi}</b><br>
            Software: <b>{$software}</b><br>
            PHP: <b>{$smarty.const.PHP_VERSION} on {$smarty.const.PHP_OS}</b><br>
            Версия CMS: <b>{$smarty.const.MZZ_VERSION}</b><br>
        {else}
            Debug-mode выключен.
        {/if}
 </tr>
</table>
<br>
