������: {$album->getName()}{$album->getJip()}<br />
�����:<br />
{foreach from=$photos item=photo}
    <img src="{$url_prefix}{$photo->getId()}.jpg" />{$photo->getName()}{$photo->getFile()->getSize()|filesize}
    <hr>
{foreachelse}
    �� ���� ���� �� ���������
{/foreach}