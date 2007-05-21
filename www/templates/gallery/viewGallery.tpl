{title append=$user}
{title append="Галерея"}
{$gallery->getJip()}<br />
<table border="1" width="100%">
    <tr valign="top">
        <td>
            Последние фотки:<br />
            {foreach from=$photos item=photo}
                <img src="{url route="galleryPicAction" album=$photo->getAlbum()->getId() user=$user pic=$photo->getId() action="viewThumbnail"}" alt="{$photo->getName()} ({$photo->getFile()->getSize()|filesize})" />
            {foreachelse}
                Ни одной фотки не загружено
            {/foreach}
        </td>
        <td>
            Альбомы:<br />
            {foreach from=$albums item=album}
                <a href="{url route=galleryAlbum user=$user album=$album->getId() action=viewAlbum}">{$album->getName()} ({$album->getPicsNumber()} фото)</a>{$album->getJip()}<br />
            {foreachelse}
                Ни одного альбома не создано
            {/foreach}
        </td>
    </tr>
</table>