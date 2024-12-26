setTimeout(function() {
    document.querySelector('.notify-alert-box').style.top = '15px'
},1000);

document.querySelector('#notify-button').onclick = async()=> {
    localStorage.setItem('notify','true');
    notifytrue();
    notifyOptions();
}

function notifytrue() {
    if(localStorage.getItem('notify','true')=='true'){
        document.querySelector('.notify-alert-box').style.display = 'none'
    }
}
notifytrue();


document.querySelector('#notify-cancel-button').onclick = async()=> {
    localStorage.setItem('notify','false');
    notifytruefalse();
}

function notifytruefalse() {
    if(localStorage.getItem('notify','false')=='false'){
        document.querySelector('.notify-alert-box').style.display = 'none'
    }
}
notifytruefalse();



function showNotification(){
    var notificationBody = new Notification('AUTO DIMENSION',{
        body:'hi',
        icon:'../img/AUTO_LOGO.png'
    });
}

function notifyOptions() {
    if(localStorage.notify == 'true'){
        if(Notification.permission == 'granted') {

        }else if(Notification.permission !== 'denied'){
            Notification.requestPermission().then(permission => {
                if(permission === 'granted'){
                    showNotification();
                }
            })
        }
    }
}

notifyOptions();
//showNotification();

//----------------------------------------------------------------//
