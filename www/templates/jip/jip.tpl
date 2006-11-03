{add file="popup.js"}
{add file="confirm.js"}

<div id="jip_menu_{$jipMenuId|replace:"/":"_"}" class="jipMenu" onmouseover="javascript: setMouseInJip(true);" onmouseout="javascript: setMouseInJip(false);">

<div class="jipMenuClose"><a href="#" onclick="javascript: showJipMenu(false, '{$jipMenuId|replace:"/":"_"}');">закрыть</a></div>
<table width="100%" border="0" cellpadding="1" cellspacing="0"> 
{foreach from=$jip item=item}
   <tr>
     <td width="20"><img align="left" src="{$item.icon}" width="16" height="16" alt="" /></td>
     <td valign="top"><a href='{$item.url}' onclick="javascript: showJipMenu(this, '{$jipMenuId|replace:"/":"_"}'); return {if not empty($item.confirm)}mzz_confirm('{$item.confirm}') &amp;&amp; {/if}showJip('{$item.url}');">{$item.title}</a></td>
   </tr>
{/foreach}
</table>
</div>
<img src="/templates/images/jip.gif"  onclick="javascript: showJipMenu(this, '{$jipMenuId|replace:"/":"_"}');">
