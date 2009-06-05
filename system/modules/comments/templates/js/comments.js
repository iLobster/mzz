var comments;
(function($) {
    comments = {
        _currentTriggers: new Array(),
        moveForm: function(commentId, folderId, aElemTrigger) {
            if (folderId in this._currentTriggers && this._currentTriggers[folderId] == aElemTrigger) {
                return;
            }

            var formElem = $('#commentForm_' + folderId);
            var nowHolder = $('#answerForm_' + folderId + '_' + commentId);

            if (formElem && nowHolder) {
                nowHolder.append(formElem);

                if (folderId in this._currentTriggers) {
                    $(this._currentTriggers[folderId]).removeClass('selected');
                }

                this._currentTriggers[folderId] = aElemTrigger;
                $(aElemTrigger).addClass('selected');
                formElem.show();
                formElem.attr('action', aElemTrigger.href);
                formElem.find('textarea').focus();
            }
        }
    }
})(jQuery);