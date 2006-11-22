<table border="0" cellpadding="0" cellspacing="1" width="50%">
    <tr>
        <td>{$page->getId()}</td>
        <td>{$page->getName()}</td>
        <td>{$page->getTitle()}</td>
        <td>{$page->getJip()}</td>
    </tr>
    <tr>
        <td colspan="4">{$page->getContent()}</td>
    </tr>
</table>
{if $page->getName() ne '403'}
    {load module="comments" section="comments" action="list" parent_id=$page->getObjId()}
{/if}