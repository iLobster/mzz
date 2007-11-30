if (typeof(mzzUploadFileSubmitValue) == 'undefined') {
    var mzzUploadFileSubmitValue = {};
}

function mzzReadUploadStatus(name) {
    $(name + 'UploadStatus').style.display = 'none';
    $(name + 'UploadStatusError').style.display = 'none';
    var mzzUploadFile = $(name + 'UploadFile');
    $(name + 'UploadSubmitButton').disable();;
    mzzUploadFileSubmitValue[name] = $(name + 'UploadSubmitButton').value;
    $(name + 'UploadSubmitButton').value = "Загрузка...";

    var frameOnLoadFunction = mzzUploadFile.onload = function () {
        var statusDivId = name + (mzzUploadFile.contentWindow.document.getElementById(name + 'UploadStatusError') ? 'UploadStatusError' : 'UploadStatus');
        $(statusDivId).style.display = 'block';
        if (!mzzUploadFile.contentWindow.document.getElementById(statusDivId)) {
            alert('Ошибка: не найден контейнер с идентификатором "' + statusDivId + '"');
            return;
        }
        $(statusDivId).innerHTML = mzzUploadFile.contentWindow.document.getElementById(statusDivId).innerHTML;

        $(name + 'UploadSubmitButton').enable();
        $(name + 'UploadSubmitButton').value = mzzUploadFileSubmitValue[name];
        if (statusDivId == 'uploadStatus') {
            $(name + 'UploadFileForm').reset();
            jipWindow.refreshAfterClose();
        }
    }

    mzzUploadFile.onload = frameOnLoadFunction;
    if(/MSIE/.test(navigator.userAgent)) {
        (mzzUploadFile.addEventListener || ('on', mzzUploadFile.attachEvent))('on' + 'load', frameOnLoadFunction, false);
    }
}

function mzzResetUploadForm(name) {
    //var mzzUploadFile = $(name + 'UploadFile').setStyle({'width': 0, 'height': 0, 'display': 'none'});
    $(name + 'UploadStatus').style.display = 'none';
    if (mzzUploadFileSubmitValue[name]) {
        $(name + 'UploadSubmitButton').value = mzzUploadFileSubmitValue[name];
        $(name + 'UploadSubmitButton').enable();
    }
}