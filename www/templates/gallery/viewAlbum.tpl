������: {$album->getName()}{$album->getJip()}<br />
�����:
{foreach from=$photos item=photo}
    {$photo->getId()}
{foreachelse}
    �� ���� ���� �� ���������
{/foreach}