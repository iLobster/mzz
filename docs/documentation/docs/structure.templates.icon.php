<p>Плагин для генерации "системных" иконок.</p>
<p>Синтаксис функции:</p>
<<code smarty>>
    {icon sprite="описание sprite'а" [jip=true] [active=true|disabled=true]}
<</code>>

<p>Описание аргументов:</p>
<ul>
        <li><strong>sprite</strong> - строка спрайта или путь до картинки;</li>
        <li><em>jip</em> - указывает на генерацию строки для jipMenu;</li>
        <li><em>active</em> - указывает на активную иконку (имеет приоритет над disabled);</li>
        <li><em>disabled</em> - указывает на неактивную иконку.</li>
</ul>

<p>Формат строки спрайта:</p>
<<code>>
sprite:name/index[/overlay]
<</code>>
<ul>
        <li><strong>sprite</strong> - название базового css-класса с картой иконок;</li>
        <li><strong>index</strong> - название css-класса самой иконки;</li>
        <li><em>overlay</em> - название css-класса bullet'a для иконки</li>
</ul>

<p>Примеры использования:</p>
<<code smarty>>
    {icon sprite="/templates/images/icon.gif"}
    {icon sprite="sprite:mzz-icon/mzz-icon-folder/mzz-overlay-add"}
    {icon sprite="sprite:mzz-icon/mzz-icon-folder/mzz-overlay-add" active=true}
    {icon sprite="sprite:mzz-icon/mzz-icon-folder/mzz-overlay-add" disabled=true}
    {icon sprite="sprite:mzz-icon/mzz-icon-folder/mzz-overlay-add" jip=true}
<</code>>

<p>Результатом выполнения этого кода будет:</p>
<<code html>>
<img src="/templates/images/icon.gif" width="16" height="16" alt="icon" />
<span class="mzz-icon mzz-icon-folder"><span class="mzz-overlay mzz-overlay-add"></span></span>
<span class="mzz-icon mzz-icon-folder active"><span class="mzz-overlay mzz-overlay-add"></span></span>
<span class="mzz-icon mzz-icon-folder disabled"><span class="mzz-overlay mzz-overlay-add"></span></span>
{'sprite':'mzz-icon','index':'mzz-icon-folder', 'overlay':'mzz-overlay-add'}
<</code>>
<p>Этот плагин используется для генерации соответсвующего html-кода или строки для jipMenu. Пока генерит иконки 16х16.</p>