<p>� GET, POST � COOKIE ���������� ���������� ���������� ����� ������ ������ <code>httpRequest</code>. � �������� ���������� ���������� ������ ���� ����� ������, ������� ����� ���� ������� �� Toolkit ��������� �������:</p>
<<code>>
$request = $toolkit->getRequest();
<</code>>
<p>��� ��������� �������� ������������ ��������� ������������ ����� <code>httpRequest::get()</code>, ������� ����� ��������� ��� ���������:
��� ������� ����������, ��� (� �������� ����� ��������� ��������) � �������� ������. �� ��������� ��� - mixed, �������� ������ - SC_REQUEST.</p>
<!-- code 1 -->
<p>��������� ����:</p>
<table border="0" cellspacing="0" cellpadding="0" class="listTable">
<thead>
<tr>
 <td><strong>���</strong></td>
 <td><strong>��������</strong></td>
</tr>
</thead>
<tr>
 <td>mixed</td>
 <td>����� ��� ������</td>
</tr>
<tr>
 <td>string</td>
 <td>������</td>
</tr>
<tr>
 <td>integer</td>
 <td>�����</td>
</tr>
<tr>
 <td>array</td>
 <td>������</td>
</tr>
<tr>
 <td>boolean</td>
 <td>������ �������� (true ��� false)</td>
</tr>
</table>
<<note>>���� �������� �������� ��������, � ��������� ��� �� 'array', �� �� ������� ����� ������� ������ �������, ������� � ����� �������� � ������� ����. ���� �� ���� �������� ��������, ��������� ����� null.<</note>>

<p><code>httpRequest</code> ����� �������� ������ �� ��������� ���������� ������:</p>
<table border="0" cellspacing="0" cellpadding="0" class="listTable">
<thead>
<tr>
 <td>���������</td>
 <td>��������</td>
</tr>
</thead>
<tr>
 <td>SC_GET</td>
 <td>������ $_GET (��� GET-�������)</td>
</tr>
<tr>
 <td>SC_POST</td>
 <td>������ $_POST (��� POST-�������)</td>
</tr>
<tr>
 <td>SC_REQUEST</td>
 <td>������ $_GET ��� $_POST (��������� ����� $_POST)</td>
</tr>
<tr>
 <td>SC_COOKIE</td>
 <td>������ $_COOKIE</td>
</tr>
<tr>
 <td>SC_SERVER</td>
 <td>������ $_SERVER</td>
</tr>
<tr>
 <td>SC_PATH</td>
 <td>����������� ���� (��������� ��������� ���� �������� ������ <code>requestRouter</code>)</td>
</tr>
</table>

<p>�� ������� ������ <code>httpRequest</code> ����� ���� �������� ����� ������, ���: ����������� URL, ������� ��������, ������, ������ �� ������ ���������� AJAX � ��. �������� ���� ������� ����� ����� � API-������������.</p>
