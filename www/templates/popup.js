function openWin(name, w, h)
{
    if ( w > 800 ) {
        w = 800;
    }
    if ( h > 600 ) {
        h = 600;
    }
    NewWindow = window.open("", name, "width="+w+",height="+h+",resizable=yes,scrollbars=yes,menubar=no,status=no,location=no,fullscreen=no,directories=no,screenX=5,screenY=5,left=5,top=5");
    NewWindow.focus();
}