{strip}
{add file="jquery.js"}
{add file="jquery-ui/ui.core.js"}
{add file="jquery-ui/effects.core.js"}
{add file="jquery-ui.css"}
{add file="jquery-ui/ui.draggable.js"}
{add file="jquery-ui/ui.resizable.js"}
{add file="dui.js"}
{add file="jquery.ex.js"}

{add file="jip.css"}
{add file="icons.css"}
{add file="bullets.css"}
{add file="flags.css"}

{add file="fileLoader.js"}
{add file="window.js"}
{add file="jip/jipMenu.js"}
{add file="jip/jipWindow.js"}
{/strip}

<div class="title">Конфигурация модулей</div>
{foreach from=$folders item="folder"}
    <div class="configurationItem">
        <a href="{url route="withAnyParam" module="config" name=$folder->getName() action="configure"}" class="mzz-jip-link"><img src="{$SITE_PATH}/templates/images/config.gif" width="16" height="16" alt="configuration"/></a>
        <a href="{url route="withAnyParam" module="config" name=$folder->getName() action="configure"}" class="mzz-jip-link">{$folder->getName()|h}</a>
    </div>
{/foreach}