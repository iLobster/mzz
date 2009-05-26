var currentShowTrigger;
function showCommentForm(formElem, aElemTrigger)
{
    if (currentShowTrigger) {
        currentShowTrigger.removeClassName('selected');
    }
    currentShowTrigger = aElemTrigger;
    currentShowTrigger.addClassName('selected');

    formElem.show();
    formElem.action = currentShowTrigger.href;
    formElem.down('textarea').focus();
}

function moveCommentForm(commentId, folderId, aElemTrigger)
{
    if (aElemTrigger == currentShowTrigger) {
        return;
    }

    var formElem = $('commentForm_' + folderId);
    var nowHolder = $('answerForm_' + folderId + '_' + commentId);
    if (formElem && nowHolder) {
        formElem.remove();
        nowHolder.update(formElem);
        showCommentForm(formElem, aElemTrigger);
    }
}