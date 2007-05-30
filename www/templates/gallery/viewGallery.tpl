{title append=$user}
{title append="Галерея"}
{$gallery->getJip()}<br />
<table border="1" width="100%">
    <tr valign="top">
        <td>
            Последние фотки:<br />
            {foreach from=$photos item="photo"}
                <a href="{url route="galleryPicAction" action="view" album=$photo->getAlbum()->getId() name=$user id=$photo->getId()}"><img src="{url route="galleryPicAction" album=$photo->getAlbum()->getId() name=$user id=$photo->getId() action="viewThumbnail"}" alt="{$photo->getName()} ({$photo->getFile()->getSize()|filesize})" /></a>
            {foreachelse}
                Ни одной фотки не загружено
            {/foreach}
        </td>
        <td>
            Альбомы:<br />
            {foreach from=$albums item="album"}
                <a href="{url route=galleryAlbum name=$user album=$album->getId() action=viewAlbum}"><img src="{url route="galleryPicAction" album=$album->getId() name=$user id=$album->getMainPhoto()->getId() action="viewThumbnail"}" /><br />
                {$album->getName()} ({$album->getPicsNumber()} фото)</a>{$album->getJip()}
                <br />
            {foreachelse}
                Ни одного альбома не создано
            {/foreach}
        </td>
    </tr>
</table>