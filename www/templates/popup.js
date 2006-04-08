function openWin(name, w, h)
{
    if (w > screen.Width) {
        w = screen.Width;
    }
    if (h > screen.Height) {
        h = screen.Height;
    }
    
    x = (screen.Width - w)/2;
 	y = (screen.Height - h)/2;
    
    NewWindow = window.open("", name, "width="+w+",height="+h+",resizable=yes,scrollbars=yes,menubar=no,status=no,location=no,fullscreen=no,directories=no,screenX="+x+",screenY="+y+",left="+x+",top="+y);
    NewWindow.focus();
}