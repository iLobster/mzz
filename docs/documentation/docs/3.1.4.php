<p>��� ������� ������ ������ (URL) � ������� ������������ ������� <code>{url}</code>. ����������� ������ ���� ������� �������� URL, ������� ������� ��:
<dl>
 <dd>- �������� ��������� (HTTP/HTTPS);</dd>
 <dd>- ������ HTTP-����� (HTTP_HOST);</dd>
 <dd>- ����� �������, ���� ������������ �� 80 ����;</dd>
 <dd>- ��������������� ����, ������� ������ � ���������������� ��������� SITE_PATH;</dd>
 <dd>- ������;</dd>
 <dd>- ����������, ���� ��� ���� �������;</dd>
 <dd>- ��������;</dd>
</dl></p>
<p>��� ��������� �������� URL ���������� <code>{url}</code> ��� �����-���� ���������� (����.: �� ������ ������ - ��� ������� PATH)</p>

<p>��������� �������:</p>
<<code>>{url section="" action="" params=""}<</code>>
<p>�������� ����������:
<dl>
        <dd>- <em>section</em>: ��� ������, �� ������� ����� ��������� URL;</dd>
        <dd>- <em>action</em>: �������� ��� ���������� section;</dd>
        <dd>- <em>params</em>: �������������� ���������, ����������� - ���� "/";</dd>
</dl></p>

<p><strong>������ 1.</strong> ����������� ������ ��� �������������� ������� � ID 4 � ������ "news" (news/4/edit):</p>
<<code>>
{url section="news" action="edit" params="4"}
<</code>>