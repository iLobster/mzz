<p class="pageTitle">Список элементов</p>
<div class="pageContent">
{foreach from=$chains item="chain" name="chain"}
{if $smarty.foreach.chain.last}
    /{$chain->getTitle()}{$chain->getJip()}
{else}
    /<a href="{url route='admin' params=$chain->getPath() section_name="catalogue" module_name="catalogue"}">{$chain->getTitle()}</a>
{/if}
{foreachelse}
{/foreach}
    <table cellspacing="0" cellpadding="3" class="tableList">
        <thead class="tableListHead">
            <tr>
                <td style="width: 30px;">&nbsp;</td>
                <td style="text-align: left;">Название</td>
                <td style="width: 120px;">Дата создания</td>
                <td style="width: 120px;">Автор</td>
                <td style="width: 30px;">JIP</td>
            </tr>
        </thead>
        {foreach from=$catalogueFolder->getFolders() item="folder"}
            {if $folder->getLevel() eq $catalogueFolder->getLevel()+1 }
            <tr>
                <td style="text-align: right; color: #8B8B8B;"><img src="{$SITE_PATH}/templates/images/news/folder.gif" /></td>
                <td style="text-align: left;"><a href="{url route='admin' params=$folder->getPath() section_name="catalogue" module_name="catalogue"}">{$folder->getTitle()}</a></td>
                <td style="text-align: center;">-</td>
                <td style="text-align: center;">-</td>
                <td style="text-align: center;">{$folder->getJip()}</td>
            </tr>
            {/if}
        {/foreach}
        
        {foreach from=$items item="item"}
            <tr>
                <td style="width: 30px; text-align: right; color: #8B8B8B;"><img src="{$SITE_PATH}/templates/images/news/news.gif" /></td>
                <td style="text-align: left;">{$item->getId()}</td>
                <td style="text-align: center;">{$item->getCreated()|date_format:"%d/%m/%Y %H:%M"}</td>
                <td style="text-align: center;">{$item->getEditor()->getLogin()}</td>
                <td style="text-align: center;">{$item->getJip()}</td>
            </tr>
        {/foreach}
        
        <tr class="tableListFoot">
            <td>&nbsp;</td>
            <td colspan="2"><a href="">1</a> <strong>2</strong> <a href="">3</a> <span style="color: #999;">...</span> <a href="">4</a></td>
            <td colspan="2" style="text-align: right; color: #7A7A7A;">60 новостей</td>
        </tr>
    </table>
</div>
<br /><br /><hr/><br /><br />

<p class="pageTitle">Список элементов</p>
<div class="pageContent">
Текущая директория: <strong>{$catalogueFolder->getTitle()}</strong> {$catalogueFolder->getJip()}
    <table cellspacing="0" cellpadding="3" class="tableList">
        <thead class="tableListHead">
            <tr>
                <td style="width: 30px;">&nbsp;</td>
                <td style="text-align: left;">Название</td>
                <td style="width: 120px;">Дата создания</td>
                <td style="width: 120px;">Автор</td>
                <td style="width: 30px;">JIP</td>
            </tr>
        </thead>
            {if $catalogueFolder->getLevel() ne 1}
            <tr>
                <td style="text-align: right; color: #8B8B8B;"><img src="{$SITE_PATH}/templates/images/news/folder.gif" /></td>
                <td style="text-align: left;"><a href="{url route='admin' params=$catalogueFolder->getTreeParent()->getPath() section_name="catalogue" module_name="catalogue"}">..</a></td>
                <td style="text-align: center;">-</td>
                <td style="text-align: center;">-</td>
                <td style="text-align: center;">{$catalogueFolder->getTreeParent()->getJip()}</td>
            </tr>
            {/if}
        {assign var="empty" value="false"}
        {foreach from=$catalogueFolder->getFolders() item="folder"}
            {if $folder->getLevel() eq $catalogueFolder->getLevel()+1 }
            <tr>
                <td style="text-align: right; color: #8B8B8B;"><img src="{$SITE_PATH}/templates/images/news/folder.gif" /></td>
                <td style="text-align: left;"><a href="{url route='admin' params=$folder->getPath() section_name="catalogue" module_name="catalogue"}">{$folder->getTitle()}</a></td>
                <td style="text-align: center;">-</td>
                <td style="text-align: center;">-</td>
                <td style="text-align: center;">{$folder->getJip()}</td>
            </tr>
            {/if}
        {foreachelse}
            {assign var="empty" value="true"}
        {/foreach}
        
        {foreach from=$items item="item"}
            <tr>
                <td style="width: 30px; text-align: right; color: #8B8B8B;"><img src="{$SITE_PATH}/templates/images/news/news.gif" /></td>
                <td style="text-align: left;">{$item->getId()}</td>
                <td style="text-align: center;">{$item->getCreated()|date_format:"%d/%m/%Y %H:%M"}</td>
                <td style="text-align: center;">{$item->getEditor()->getLogin()}</td>
                <td style="text-align: center;">{$item->getJip()}</td>
            </tr>
        {foreachelse}
            {if $empty eq "true"}
            <tr>
                <td style="width: 30px; text-align: right; color: #8B8B8B;"></td>
                <td style="text-align: left;">Тут нихрена нет</td>
                <td style="text-align: center;"></td>
                <td style="text-align: center;"></td>
                <td style="text-align: center;"></td>
            </tr>
            {/if}
        {/foreach}
        
        <tr class="tableListFoot">
            <td>&nbsp;</td>
            <td colspan="2"><a href="">1</a> <strong>2</strong> <a href="">3</a> <span style="color: #999;">...</span> <a href="">4</a></td>
            <td colspan="2" style="text-align: right; color: #7A7A7A;">60 новостей</td>
        </tr>
    </table>
</div>
<br /><br /><br />
<p class="pageTitle">Список типов</p>
<div class="pageContent">
    <table cellspacing="0" cellpadding="3" class="tableList">
        <thead class="tableListHead">
            <tr>
                <td style="width: 30px;"><a href="{url route="default2" section="catalogue" action="addType"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/add.gif" alt="добавить тип" title="Добавить тип" align="texttop" border="0" /></a></td>
                <td style="text-align: left;">Название</td>
                <td style="text-align: left;">Тип</td>
                <td style="width: 30px;">JIP</td>
            </tr>
        </thead> 
    {foreach from=$types item="type"}
        <tr>
            <td>&nbsp;</td>
            <td>{$type.title}</td>
            <td>{$type.name}</td>
            <td align="center">
                {capture name="menuId"}jip_types_{$type.id}{/capture}
                {include file="jip.tpl" jipMenuId=$smarty.capture.menuId jip=$jipTypes[$type.id]}
            </td>
        </tr>
    {/foreach}
    </table>
</div>
<br /><br />
<p class="pageTitle">Список Параметров</p>
<div class="pageContent">
    <table cellspacing="0" cellpadding="3" class="tableList">
        <thead class="tableListHead">
            <tr>
                <td style="width: 30px;"><a href="{url route="default2" section="catalogue" action="addProperty"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/add.gif" alt="добавить свойство" title="Добавить свойство" border="0" align="texttop" /></a></td>
                <td style="text-align: left;">Название</td>
                <td style="text-align: left;">Свойство</td>
                <td style="text-align: left;">Тип</td>
                <td style="width: 30px;">JIP</td>
            </tr>
        </thead> 
    {foreach from=$properties item="property"}
        <tr>
            <td>&nbsp;</td>
            <td>{$property.title}</td>
            <td>{$property.name}</td>
            <td>{$property.type}</td>
            <td align="center">
                {capture name="menuId"}jip_properties_{$property.id}{/capture}
                {include file="jip.tpl" jipMenuId=$smarty.capture.menuId jip=$jipProperties[$property.id]}
            </td>
        </tr>
    {/foreach}
    </table>
</div>