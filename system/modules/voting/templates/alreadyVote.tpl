{$vote->getQuestion()->getQuestion()}{$vote->getQuestion()->getJip()}<br />
{foreach name="answersIterator" from=$vote->getQuestion()->getAnswers() item="answer"}
{$answer->getName()}<br />
{/foreach}
�� ��� ������ ���� �����: {$vote->getAnswer()->getName()}<br />
<a href="{url route="withAnyParam" action="results" name=$vote->getQuestion()->getName()}">����������</a>