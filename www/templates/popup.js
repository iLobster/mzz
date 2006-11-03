function openWin(href, name, w, h)
{
    if (w > screen.Width) {
        w = screen.Width;
    }
    if (h > screen.Height) {
        h = screen.Height;
    }
    
    x = (screen.Width - w)/2;
 	y = (screen.Height - h)/2;
    
    NewWindow = window.open(href, name, "width="+w+",height="+h+",resizable=yes,scrollbars=yes,menubar=no,status=no,location=no,fullscreen=no,directories=no,screenX="+x+",screenY="+y+",left="+x+",top="+y);
    NewWindow.focus(); 
    return false;
}


var last_jipmenu_id;
var agt = navigator.userAgent.toLowerCase();
var is_ie = (agt.indexOf("msie") != -1) && (agt.indexOf("opera") == -1);
var is_gecko = navigator.product == "Gecko";

var layertimer;

function getBottomPosition(el)
{
     if(!el || !el.offsetParent) {
          return false;
     }

     top_position = el.offsetTop;
     var objParent = el.offsetParent;

     while(objParent && objParent.tagName != "body")
     {
          top_position += objParent.offsetTop;
          objParent = objParent.offsetParent;
     }
     return top_position + el.offsetHeight;
}




function openJipMenu(button, jipMenu, id) {


	jipMenu.style.top = '-100px';
        jipMenu.style.display = 'block';

        if (last_jipmenu_id) {
             closeJipMenu(document.getElementById('jip_menu_' + last_jipmenu_id));
        }

        if (is_gecko) {
            curr_x = button.x;
            curr_y = button.y + 17;
        } else {
            e = window.event;

            curr_x = (e.pageX) ? e.pageX : e.x /*+ document.documentElement.scrollLeft*/;
            curr_y = (e.pageY) ? e.pageY : e.y /*+ document.documentElement.scrollTop*/;
        } 


        var bottom_position = getBottomPosition(button);

        var x = curr_x , y = curr_y;
        var w = jipMenu.offsetWidth;
        var h = jipMenu.offsetHeight;
        var body = document.documentElement;

        if((body.clientWidth + body.scrollLeft) < (x + jipMenu.clientWidth))
        {
                x = body.scrollLeft + body.clientWidth - 207;
        }

        if((body.clientHeight + body.scrollTop) < (bottom_position + jipMenu.clientHeight + 30))
        {
                y = body.scrollTop - jipMenu.clientHeight + 30;
        }

        jipMenu.style.left = x + 'px';
        jipMenu.style.top = y + 'px';

        last_jipmenu_id = id;
}

function closeJipMenu(jipMenu) { 
        jipMenu.style.display = 'none';
        last_jipmenu_id = false;
        if(layertimer) {
            clearTimeout(layertimer);
        }
}


function showJipMenu(button, id) {
    jipMenu = document.getElementById('jip_menu_' + id);
    if (!jipMenu.style.display || jipMenu.style.display == 'none') { 
        openJipMenu(button, jipMenu, id);
    } else {
        closeJipMenu(jipMenu);
    }
}

function setMouseInJip(status) { 
   if (status == false && last_jipmenu_id) {
      jipMenu = document.getElementById('jip_menu_' + last_jipmenu_id);
      layertimer = setTimeout("closeJipMenu(jipMenu)", 800);
   } else {
      clearTimeout(layertimer);
   }
}
