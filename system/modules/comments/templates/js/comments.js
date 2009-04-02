var baseUrl;
function getForm(commentId, folderId)
{
    var formElem = $('commentForm_' + folderId);
    if (formElem) {
        if (!baseUrl) {
            baseUrl = formElem.action;
        }

        formElem.action = baseUrl + '?replyTo=' + commentId;

        return formElem;
    }
}

var currentCommentAnswer;
function showAnswerForm(commentId, folderId) {
    var tmp = $('comment_' + commentId  + '_answer');
    if (tmp != currentCommentAnswer) {
        if (currentCommentAnswer) {
            currentCommentAnswer.removeClassName('selected');
        }

        currentCommentAnswer = tmp;
        currentCommentAnswer.addClassName('selected');

        var formHolder = $('comment_' + commentId  + '_answerForm');
        formHolder.update(getForm(commentId, folderId));
    }
}