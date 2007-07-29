<p>��� ������� ������ (URL) � ������ ����� ������������ ������� <code>{url}</code>. ����������� ������ ���� ������� �������� ��������������� URL, ������� ������� ��:
<dl>
 <dd>- �������� ��������� (HTTP/HTTPS);</dd>
 <dd>- ������ HTTP-����� (HTTP_HOST);</dd>
 <dd>- ����� �������, ���� ������������ �� 80 ����;</dd>
 <dd>- ��������������� ����, ������� ������ � ���������������� ��������� SITE_PATH;</dd>
 <dd>- ������;</dd>
 <dd>- ����������, ���� ��� ���� �������;</dd>
 <dd>- ��������;</dd>
</dl></p>
<p>��� ��������� �������� URL ���������� <code>{url}</code> ��� �����-���� ����������.</p>

<p>��������� �������:</p>
<<code smarty>>
{url section="������" action="��������" route="�������������"}
<</code>>
<p>�������� ����������:
<dl>
        <dd>- <em>section</em>: ��� ������, �� ������� ����� ��������� URL. ���� �� �������, ����� ������������ �������;</dd>
        <dd>- <em>action</em>: �������� ��� ���������� section;</dd>
        <dd>- <em>route</em>: ��� ��������������, ������� ����� ����������� ��� ��������� URL.</dd>
</dl></p>
</p>��� ��������� �������� �� �������������.</p>
<p>������� ����� ��������� ��� �� � ����� ������ ���������, ������� ����� �������� �����������.
�������� ��������� http://example.com/news/4/asc/edit � ����������� � ��������������� <code>:section/:id/:sort/:action</code> ��������:
</p>
<<code smarty>>
{url section="news" action="edit" id="4" sort="asc" route="newsList"}
<</code>>

<p>������ ��������� URL ��� �������������� ������� � ID 4 � ������ "news" (http://example.com/news/4/edit):</p>
<<code smarty>>
{url section="news" action="edit" id="4"}
<</code>>
<<note>>
������� ���������� ������ URL. ��������, ������� �� ������� ����� ��������� �������: <code>&lt;a href="{url}"&gt;link&lt;/a&gt;</code>
<</note>>