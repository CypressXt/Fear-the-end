/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var max = 100;
var min = -200;
var opacite = min;
up = true;
var IsIE = !!document.all;
var ThePic = document.getElementById("fade");

function fadePic() {
    if (opacite < max && up) {
        opacite += 2;
    }
    if (opacite >= max) {
        up = false;
    }
    if (opacite <= min) {
        up = true;
    }



    IsIE ? ThePic.filters[0].opacity = opacite : document.getElementById("fade").style.opacity = opacite / 70;
}


if (getCookie("loggedCookies") != "loggedOnce") {
    setInterval(function() {
        fadePic();
    }, 10)
}

function getCookie(name)
{
    var re = new RegExp(name + "=([^;]+)");
    var value = re.exec(document.cookie);
    return (value != null) ? unescape(value[1]) : null;
}