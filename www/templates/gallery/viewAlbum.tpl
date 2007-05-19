Альбом: {$album->getName()}{$album->getJip()}<br />
Фотки:<br />
{foreach from=$photos item=photo}
    <img src="{$url_prefix}{$photo->getId()}.jpg" />{$photo->getName()}{$photo->getFile()->getSize()|filesize}
    <hr>
{foreachelse}
    Ни одно фото не загружено
{/foreach}