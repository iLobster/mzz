Альбом: {$album->getName()}{$album->getJip()}<br />
Фотки:
{foreach from=$photos item=photo}
    <img src="{$url_prefix}{$photo->getId()}.jpg" />{$photo->getName()}
{foreachelse}
    Ни одно фото не загружено
{/foreach}