{add file="admin/toolbar.css"}
{add file="admin/devToolbar.js" require="jquery.js,dui.js,jquery.ex.js"}

{include file="admin/title.tpl" title="devToolBar"}
<div class="toolbarBlockWrap">
    <div id="modulesApp" class="toolbarBlock">
        <span class="toolbarSectionName"><strong>Модули</strong> и классы <a href="{url route="default2" module="admin" action="addModule"}" class="mzz-jip-link">{icon sprite="sprite:admin/module-add/admin"}</a></span>
        {include file="admin/toolbarModules.tpl" mods=$modules.app}
    </div>
 </div>
<div class="toolbarBlockWrap">
    <div id="modulesSys" class="toolbarBlock">
        <span class="toolbarSectionName"><strong>Системные Модули</strong> и классы</span>
         {include file="admin/toolbarModules.tpl" mods=$modules.sys}
    </div>
 </div>