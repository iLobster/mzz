if (typeof(mzzUploadFileSubmitValue) == 'undefined') {
    var mzzUploadFileSubmitValue = {};
}

function mzzReadUploadStatus(name) {
    (function ($){
    $('#' + name + 'UploadStatus').css('display', 'none');
    $('#' + name + 'UploadStatusError').css('display', 'none');
    var mzzUploadFile = $('#' + name + 'UploadFile')[0];
    $('#' + name + 'UploadSubmitButton').attr('disabled', 'disabled');
    mzzUploadFileSubmitValue[name] = $('#' + name + 'UploadSubmitButton').attr('value');
    $('#' + name + 'UploadSubmitButton').attr('value', "Загрузка...");

    var frameOnLoadFunction = mzzUploadFile.onload = function () {
       (function ($){
        var statusDivId = name + (mzzUploadFile.contentWindow.document.getElementById(name + 'UploadStatusError') ? 'UploadStatusError' : 'UploadStatus');
        $('#' + statusDivId).css('display', 'block');
        if (!mzzUploadFile.contentWindow.document.getElementById(statusDivId)) {
            alert('Ошибка: не найден контейнер с идентификатором "' + statusDivId + '". ' + "Ответ сервера: \n" + mzzUploadFile.contentWindow.document.body.innerHTML);
            return;
        }
        $('#' + statusDivId).html(mzzUploadFile.contentWindow.document.getElementById(statusDivId).innerHTML);

        $('#' + name + 'UploadSubmitButton').attr('disabled', false);
        $('#' + name + 'UploadSubmitButton').attr('value', mzzUploadFileSubmitValue[name]);
        if (statusDivId == 'uploadStatus') {
            $('#' + name + 'UploadFileForm').reset();
            jipWindow.refreshAfterClose();
        }
        })(jQuery);
    }
    mzzUploadFile.onload = frameOnLoadFunction;
    if(/MSIE/.test(navigator.userAgent)) {
        (mzzUploadFile.addEventListener || ('on', mzzUploadFile.attachEvent))('on' + 'load', frameOnLoadFunction, false);
    }
    })(jQuery);
}

function mzzResetUploadForm(name) {
    (function ($){
    //var mzzUploadFile = $(name + 'UploadFile').setStyle({'width': 0, 'height': 0, 'display': 'none'});
    $('#' + name + 'UploadStatus').css('display', 'none');
    if (mzzUploadFileSubmitValue[name]) {
        $('#' + name + 'UploadSubmitButton').attr('value', mzzUploadFileSubmitValue[name]);
        $('#' + name + 'UploadSubmitButton').attr('disabled', false);
    }
    })(jQuery);
}