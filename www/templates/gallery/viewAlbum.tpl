Альбом: {$album->getName()}{$album->getJip()}<br />
Фотки:
{foreach from=$photos item=photo}
    {$photo->getId()}
{foreachelse}
    Ни одно фото не загружено
{/foreach}