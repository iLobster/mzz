������: {$album->getName()}{$album->getJip()}<br />
�����:
{foreach from=$photos item=photo}
    <img src="{$url_prefix}{$photo->getId()}.jpg" />{$photo->getName()}
{foreachelse}
    �� ���� ���� �� ���������
{/foreach}