        <li class="hcomment new">
            <div class="entry-info"><span class="entry-author">{$comment->getUser()->getLogin()|h}</span> {$comment->getJip()}</div>
            <div class="entry-comment">{$comment->getText()|h|nl2br}</div>
            <a class="answer" href="{url route="withId" module="comments" action="post" id=$commentsFolder->getId()}?replyTo={$comment->getId()}" onclick="comments.moveForm({$comment->getId()}, {$commentsFolder->getId()}, this); return false;">Ответить</a>
            <ul>
                <li id="answerForm_{$commentsFolder->getId()}_{$comment->getId()}">
                    {load module="comments" module="comments" action="post" tplPrefix="ajax_" onlyForm=true hideForm=true id=$commentsFolder onlyForm=true}
                </li>
            </ul>
        </li>