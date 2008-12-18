{* main="admin/main/adminHeader.tpl" placeholder="content" *}
<div id="page">
    <div id="header">
        <div class="loginInfo">{load module="user" action="login" section="user" onlyForm=true tplPrefix="admin"}</div>
        <div class="siteName"><div><a href="{$SITE_PATH}/">www.mzz.ru</a></div></div>
        <div class="favorite">
            <div>
                <a href="{$SITE_PATH}/"><img src="{$SITE_PATH}/templates/images/admin/favorite.gif" class="favoriteIcon" width="18" height="16" alt="Site" title="Перейти на сайт" /></a>
                <!--span class="doubleSeparator">&nbsp;</span> <a href="#">Добавить новость</a>
                <span>&nbsp;</span> <a href="#">Добавить страницу</a-->
                <div class="langs">
                {foreach name="langs" from=$available_langs item="lang"}
                {assign lang_name=$lang->getName()}
                {if $current_lang neq $lang_name}
                    <a href="{url lang=$lang_name}">{$lang_name|strtoupper}</a>
                {else}
                    {$lang_name|strtoupper}
                {/if}
                {if !$smarty.foreach.langs.last} | {/if}
                {/foreach}
                </div>
            </div>
        </div>
    </div>
    {if not empty($admin_menu)}
        <div id="sidebar">
            <p class="sideMenuTitle">Разделы сайта</p>
            {*<a href="{url route=withAnyParam section="admin" name="`$section_name`/`$module_name`" action="admin"}"> *}
            <table cellspacing="0" cellpadding="0">
            {foreach from=$admin_menu item=module key=module_name}
                {if sizeof($module.sections) == 1}
                    <tr>
                        <td class="menuSectionImg"><img src="{$SITE_PATH}/templates/images/admin/{$module.icon}" alt="" /></td>
                        {assign var='section_name' value=$module.sections|@key}
                        <td class="menuSection"><a href="{url route=withAnyParam section="admin" name=$module_name action="admin"}">
                            {if $module_name eq $current_module}<strong>{/if}
                            {$module.title}
                            {if $module_name eq $current_module}</strong>{/if}
                        </a></td>
                    </tr>
                {else}
                    <tr>
                        <td class="menuSectionImg"><img src="{$SITE_PATH}/templates/images/admin/{$module.icon}" alt="" /></td>
                        <td class="menuSection">{$module.title}</td>
                    </tr>
                    {foreach from=$module.sections item=section key=section_name}
                        <tr>
                            <td>&nbsp;</td>
                            <td class="menuLink"><a href="{url route=withAnyParam section="admin" name="`$section_name`/`$module_name`" action="admin"}">
                                {if $module_name eq $current_module}{if $section_name eq $current_section}<strong>{/if}{/if}
                                {$section.title}
                                {if $module_name eq $current_module}{if $section_name eq $current_section}<strong>{/if}{/if}
                            </a></td>
                    </tr>
                    {/foreach}
                {/if}
            {/foreach}
                  <tr>
                      <td class="menuSectionImg"><img src="{$SITE_PATH}/templates/images/admin/config.gif" alt="" /></td>
                      {assign var='section_name' value=$module.sections|@key}
                      <td class="menuSection"><a href="{url route="default2" section="admin" action="configuration"}">
                          {if $current_action eq 'configuration'}<strong>{/if}
                          Конфигурация
                          {if $current_action eq 'configuration'}</strong>{/if}
                      </a></td>
                  </tr>
            </table>
            <div class="patch_minheight"></div>
        </div>
    {/if}

    <div id="mainbar{if empty($admin_menu)}WithoutSidebar{/if}">
    {$content}
    <div class="patch_minheight"></div>
    </div>

    <div class="footer_guarantor">&nbsp;</div>
</div>

<div class="footer">{$smarty.const.MZZ_NAME} (v.{$smarty.const.MZZ_VERSION}-{$smarty.const.MZZ_REVISION}) 2005-{"Y"|date}.
{$timer->toString('timer/admin/timer.tpl')}
</div>

</body>
</html>