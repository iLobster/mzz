<p>JIP - ��� ������� ������ � ��������� ��� ��������.</p>
<p>��� ��������, �� ������� ���� ����� � �������� ������������, ������� � ���� ��������� ����, ������� ������������ ��� ������� �� ������ JIP ����� � ��������. ��� ������� �� ����� ������� ����������� JIP ���� � ��������� ���������� AJAX ��������� ��������� �������� ��� �������� �� ������� ������� ��������.</p>

<p>���������� ���������� ����� JIP ������� �� ���� Javascript-������: <code>prototype.js</code>, <code>effects.js</code>, <code>jip.js</code>
� ������ CSS: <code>jip.css</code>. ��� ��������� ����� ������������ ������ ��� ������� �� �������� ���� �� ������ JIP-����. ����������� Javascript/CSS ������, ������������ ������ � JIP-�����, ����� ������������� � ������� <code>jip.tpl</code> (��. <a href="structure.templates.html#structure.templates.add">{add}</a>).</p>
<<note>>
������ JIP ���������� ������ ����� � �������� ������������ ���� ���� �� ���� ����������� �������� ��� ��������.
<</note>>

<p>� �������� JavaScript Framework ������������ <a href="http://www.prototypejs.org/">Prototype</a>, ����������� ����������� ���������� JavaScript ���������. ����� ����, ������������  ���������� <a href="http://script.aculo.us/">script.aculo.us</a>.</p>

<p>JIP ����� ������ DataObject, ������������� �� ������ <code>simple</code>.</p>

<p>��������, ������� �������� � ���� ��� ������� ���� �� ���, ����� ����� <code>jip</code> �� ��������� 1 � ������������ ��������:</p>
<<code>>
[edit]<br />
controller = "edit"<br />
jip = "1"
<</code>>

<p>��� ����������� ������ JIP ���������� � ������� ������� ����� <code>simple::getJip()</code>:</p>
<<code>>
{$news->getJip()}
<</code>>

<p>��� ������� �� ���� �� ��������� ��������������� �������� ����������� � JIP-����.</p>

<p>����� � JIP-���� ����������� ����� ������, ������������� CSS-������ <code>jipLink</code>:</p>
<<code>>
&lt;a href="{url route="default" section="news" action="info"}" class="jipLink"&gt;���. ����������&lt;/a&gt;
<</code>>
<p>����������� � JIP-���� �������� ������ ��������� ��� ������� ��� ���������. �� ������������ HTML-��������� &lt;DIV&gt;, ������� ����������� � CSS-������ <code>jipTitle</code>:</p>
<<code>>
&lt;div class="jipTitle"&gt;������� �������&lt;/div&gt;
<</code>>

<p>����� ����� ��������� ����� Ajax ������� ������� <code>onsubmit="return mzzAjax.sendForm(this);"</code>:</p>
<<code>>
&lt;form action="/winner/add" method="post" onsubmit="return mzzAjax.sendForm(this);"&gt;<br />
���: &lt;input size="60" name="name" type="text"&gt;<br />
&lt;input type="submit"&gt;<br />
&lt;/form&gt;
<</code>>

������� JIP-���� ����� ������� Javascript-������� <code>jipWindow.close()</code>:
<<code>>
&lt;input type="reset" onclick="jipWindow.close();"&gt;<br />
&lt;a href="javascript: void(jipWindow.close());"&gt;�������&lt;/a&gt;
<</code>>