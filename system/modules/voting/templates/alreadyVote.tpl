{$vote->getQuestion()->getQuestion()}{$vote->getQuestion()->getJip()}<br />
{foreach name="answersIterator" from=$vote->getQuestion()->getAnswers() item="answer"}
{$answer->getTitle()}<br />
{/foreach}
�� ��� ������ ���� �����: {$vote->getAnswer()->getTitle()}<br />
<a href="{url route="withAnyParam" action="results" name=$vote->getQuestion()->getName()}">����������</a>