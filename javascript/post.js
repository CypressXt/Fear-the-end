/* 
############################
PHP POST CALL
############################
*/

function addMemberTeam(projectID, document) {
    var functionSelect = document.getElementById("roles");
    var idUserFunction = functionSelect.options[functionSelect.selectedIndex].value;
    var userName = document.getElementById("userName").value;
    
    
    $.post('/model/AjaxCall.php', {l: "project",methode: "addMemberTeam", projectID: projectID, idUserFunction: idUserFunction, userName: userName}, function(e) {
        alert(e);
    });
}