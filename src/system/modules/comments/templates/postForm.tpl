        <dl>
            <dt>{form->caption name="text" value="Текст:" onError=""}</dt>
            <dd>{form->textarea name="text" value=$comment->getText() rows="5" cols="5" useDefault=$onlyForm}</dd>
        </dl>
        <p>
            {form->hidden name="backUrl" value=$backUrl}
            {form->submit class="send" name="commentSubmit" value="Отправить комментарий"}
        </p>