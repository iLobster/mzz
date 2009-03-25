{add file="prototype.js"}
{add file="prototype_improvements.js"}
{add file="effects.js"}
{add file="jip.css"}
{add file="jip.js"}
<div class="pageTitle">Конфигурация модулей</div>
<div class="pageContent">

{foreach from=$info item=module key=module_name}
        {if not empty($module.editACL)}
            <div class="configurationItem">
                <a href="{url route="withAnyParam" section="admin" name="$module_name" action="editConfig"}" class="jipLink">
                <img src="{$SITE_PATH}/templates/images/config.gif" width="16" height="16" alt="configuration"/></a>
                <a href="{url route="withAnyParam" section="admin" name="$module_name" action="editConfig"}" class="jipLink">
                {$module_name}</a>
            </div>
        {/if}
{/foreach}

</div>
</div>
