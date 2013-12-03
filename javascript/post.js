/* 
 ############################
 PHP POST CALL
 ############################
 */

function addMemberTeam(projectID, document) {
    var functionSelect = document.getElementById("roles");
    var idUserFunction = functionSelect.options[functionSelect.selectedIndex].value;
    var userName = document.getElementById("userName").value;


    $.post('/controller/AjaxCall.php', {methode: "addMemberTeam", projectID: projectID, idUserFunction: idUserFunction, userName: userName}, function(e) {
        if (e !== "") {
            alert(e);
        } else {
            location.reload();
        }
    });
}


function delMemberTeam(projectID,userFunctionID, username) {
    $.post('/controller/AjaxCall.php', {methode: "delMemberTeam", projectID: projectID,userFunctionID: userFunctionID, userName: username}, function(e) {
        if (e !== "") {
            alert(e);
        } else {
            location.reload();
        }
    });
}

function changeProjectStatus(projectID, document) {
    var functionSelect = document.getElementById("status");
    var idStatus = functionSelect.options[functionSelect.selectedIndex].value;
    $.post('/controller/AjaxCall.php', {methode: "changeProjectStatus", projectID: projectID, statusID: idStatus}, function(e) {
        if (e !== "") {
            alert(e);
        } else {
            location.reload();
        }
    });
}