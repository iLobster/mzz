cssLoader.load(SITE_PATH + '/templates/css/fileBrowse.css');
var mzzFileBrowse = {
    lastFile: false,
    options: null,

    makeSelected: function(elm)
    {
        if (this.lastFile == elm.id) {
            return;
        }
        if (this.lastFile) {
            $(this.lastFile).removeClassName('selectedFile');
        }
        $(elm).addClassName('selectedFile');
        this.lastFile = elm.id;
        this.showDetails(elm);
    },

    selectFile: function(elm, fileId)
    {

        elm = $(elm);

        if (elm.hasClassName('alreadySelectedFile')) {
            return;
        }

        if (!this.checkOptions()) return false;

        var isMultiple = mzzFileBrowse.options.hiddenName.endsWith('[]');

        elm.removeClassName('selectedFile');
        elm.addClassName('alreadySelectedFile');

        var fileThumb = (elm.getElementsBySelector('img') || [])[0];

        $(mzzFileBrowse.options.target).up('form').insert(new Element("input", { name: mzzFileBrowse.options.hiddenName, value: fileId, type: "hidden" }));

        var newThumb = '<div class="fmBrowseThumbWrap">'
        + '<div class="fmBrowseThumb"><img src="' + fileThumb.src + '" title="' + fileThumb.title + '" alt="' + fileThumb.alt + '" /></div>'
        + '<span><a href="#" onclick="return mzzFileBrowse.removeFile(this, mzzFileBrowse.options.hiddenName, ' + fileId + ');">������</a></span></div>';

        isMultiple ? $(mzzFileBrowse.options.target).insert(newThumb) : $(mzzFileBrowse.options.target).update(newThumb);

        if (isMultiple) {
            new Effect.Highlight(elm);
        } else {
            jipWindow.close();
        }
    },

    removeFile: function(file, name, id) {
        if (confirm('�� ������� ��� ������ ������� ���� ����?')) {
            var _elm = $(file).up('div.fmBrowseThumbWrap');
            new Effect.Fade(_elm, {afterFinish: function() {
                _elm.remove();
            }});
            file.up('form').getInputs('hidden', name).each(function(elm) {
                if ($F(elm) == id) {
                   elm.remove();
                   throw $break; 
                }
            });
        }
        return false;
    },

    showDetails: function(elm)
    {
        new Effect.Opacity('fmBrowseDetailsWrap', {duration:0.2, from:1.0, to:0.01,
        afterFinish: function() {
            elm = $(elm);
            var fileThumb = (elm.getElementsBySelector('img') || [])[0];
            var details = '<div class="fmBrowseDetails">';
            if (fileThumb) {
                details += '<img src="' + fileThumb.src + '" title="' + fileThumb.title + '" />';
            }
            details += '<div class="fmBrowseDetailsText">' + ((elm.getElementsByClassName('fileDetails') || [])[0].innerHTML) + '</div></div>';

            $('fmBrowseDetailsWrap').update(details);
            new Effect.Opacity('fmBrowseDetailsWrap', {duration: 0.2, from: 0.01, to: 1.0});
        }

        });

    },

    checkOptions: function() {
        if (this.options != null) return true;

        if (!mzzRegistry.has('fileBrowseOptions')) {
            alert('���������� "fileBrowseOptions", ���������� ��������� ��������� ������, �� ����������� � Registry.');
            return false;
        }
        this.options = mzzRegistry.get('fileBrowseOptions');

        if (typeof(this.options.target) == 'undefined') {
            alert('����� "target" ��� ��������� ������, ���������� ������������� ������ ��� �������, �� �����������.');
            this.options = null;
            return false;
        }
        if (typeof(this.options.hiddenName) == 'undefined') {
            alert('����� "hiddenName" ��� ��������� ������, ���������� ��� �������� ���� ����� � ���������� �������, �� �����������.');
            this.options = null;
            return false;
        }
        if (!$(this.options.target)) {
            alert('������� � ��������������� "' + elmId + '" �� ������.');
            this.options = null;
            return false;
        }
        return true;
    }
}