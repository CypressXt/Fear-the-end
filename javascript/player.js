/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var playing = false;
var audio;
var logDiv;
var pb;

function initAll(player, log, progress) {
    audio = player;
    logDiv = log;
    pb = progress;

    if (getCookie("loggedCookies") !== "loggedOnce") {
        //alert("first time here");
        audio.play();
        playing = true;
    }
}

function play() {
    if (playing) {
        audio.pause();
        playing = false;
    } else {
        audio.play();
        playing = true;
    }
}

function info() {
    pb.setAttribute("max", audio.duration.toString());
    pb.value = audio.currentTime;
}


function getCookie(name) {
    var re = new RegExp(name + "=([^;]+)");
    var value = re.exec(document.cookie);
    return (value !== null) ? unescape(value[1]) : null;
}