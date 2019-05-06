function IsJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}


var input = document.getElementById('checkbox');
var notif = document.getElementById('doNotifRequest');

var xhr = new XMLHttpRequest();
xhr.open('POST', '/settings/isNotified');
xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhr.send(null);

xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) {
        if (IsJsonString(xhr.responseText)){
            var data = JSON.parse(xhr.responseText);
            if (data.is_notified == 1){
                input.checked = true;
                input.value = "activate";
            }else {
                input.checked = false;
                input.value = "disable";
            }
        }
    }
}

input.addEventListener('click', function(e){
    if (this.checked == true){
        this.value = "activate";
    }
    if (this.checked == false){
        this.value = "disable";
    }
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/settings/modifNotif');
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send('notification='+this.value);
});
