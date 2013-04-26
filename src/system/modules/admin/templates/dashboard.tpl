<table class="admin dashboard" width="40%">
    <thead>
        <tr class="first center">
            <th class="first left" width="150">Общая информация</th>
            <th class="last">&nbsp;</th>
        </tr>
    </thead>
    <tr class="last">
        <td class="first left">Версия приложения</td>
        <td class="last">{systemConfig::$appVersion}</td>
    </tr>
    <tr>
        <td class="first left">Версия PHP</td>
        <td class="last">{$smarty.const.PHP_VERSION}</td>
    </tr>
    <tr class="last">
        <td class="first left">Версия MZZ</td>
        <td class="last">{$smarty.const.MZZ_VERSION}{if $smarty.const.MZZ_REVISION}-{$smarty.const.MZZ_REVISION}{/if}</td>
    </tr>
</table>
