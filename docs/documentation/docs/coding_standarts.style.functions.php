<p>������ ������ ������ ���������� ���� ������� ��������� � ������� ������ �� ��������� private, protected ��� public.</p>

<p>��� � � �������, �������� ������ ������ ������� �� ��������� ������ ��� ������ �������. ������� ����� ������ ������� � ������� ������� ��� ���������� �����������. ��������� ����������� ��������.</p>

<p>������� � ���������� ������� ��������� ������ �� ��������������.</p>

<p>������ ����������� ������:</p>
<<code>>
/**<br />
&nbsp;* ���� ������������<br />
&nbsp;*/<br />
class Foo<br />
{<br />
&nbsp;&nbsp;&nbsp;&nbsp;/**<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* ���� ������������<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*/<br />
&nbsp;&nbsp;&nbsp;&nbsp;public function bar($arg, $name, $value = 'default')<br />
&nbsp;&nbsp;&nbsp;&nbsp;{<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;// ���������� ������<br />
&nbsp;&nbsp;&nbsp;&nbsp;}<br />
}
<</code>>

<p>������������ �������� �� ������ ����������� � ������� ������:</p>
<<code>>
return $this->bar; // ���������<br />
return($this->bar); // �����������
<</code>>