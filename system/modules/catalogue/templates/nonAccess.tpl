<div class="jipTitle">Внимание!</div>
Над следующими объектами не было произведено действий, так как у вас недостаточно прав для этой операции: <br /><br />
{foreach from=$items item="item"}
    {$item->getId()}: <strong>{$item->getName()|htmlspecialchars}</strong><br />
{/foreach}
<br />{form->reset jip=true name="reset" value="OK"}