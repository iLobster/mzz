function insertBbCode(open, close, textarea) {
  textarea = document.getElementById(textarea);
  if (document.selection == 'undefined' && textarea.setSelectionRange == 'undefined') {
    return;
  }

  textarea.focus();

  var selected, newstr, srange;

  if (document.selection != undefined) {
    selected = document.selection.createRange().text;
  } else {
    var start, end, scrollPos;
    start = textarea.selectionStart;
    end = textarea.selectionEnd;
    selected = textarea.value.substring(start, end);
    scrollPos = textarea.scrollTop;
  }

  if ((selected.length - 1) >= 0 && this.lastIndexOf(' ') === (selected.length - 1)) {
    selected = selected.substring(0, selected.length - 1);
    close += ' ';
  }

  newstr = open + selected + close;

  if (document.selection != undefined) {
    var range = document.selection.createRange().text = newstr;
    textarea.caretPos -= close.length;
  } else {
    textarea.value = textarea.value.substring(0, start) + newstr + textarea.value.substring(end);

    var srange = start + (selected ? newstr.length : open.length);
    textarea.setSelectionRange(srange, srange);
    textarea.scrollTop = scrollPos;
  }
}