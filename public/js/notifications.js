// const url = 'http://192.168.1.24:81/api/stations/';
// const urlBase = 'http://192.168.1.24:81/';
const url = 'http://localhost:8000/api/notifications/';
const urlBase = 'http://localhost:8000/';
libs = new Libs();
notification = new Notification();

document.addEventListener('DOMContentLoaded', (ev)=>{
    notification.getNotifications();
});

class Notification{

    getNotifications(){
        fetch(url + `get/${id}`, {
            method: 'GET',
            mode: 'cors',
            cache: 'default'
        })
        .then((response) => response.json())
        .then((data) => {
            this.loadNotifications(data.notifications);
            loadGraphics(data);
        });
    }

    loadNotifications(notifications) {
        libs.removeChilds(document.getElementById('notificationMobile'));
        libs.removeChilds(document.getElementById('notificationWeb'));

        tr = document.createElement('tr');

        let state;
        if(notifications.state == 'Correcto'){
            state = 'green'
        }else{
            state = 'red';
        }

        modelNotification = `
        <td>
            <strong>${notifications[i].}</strong><br>
            Temp: 15.0 <br>
            Radiación: 20 <br>
            Humedad: 30
            <a href="#" class="${state}white-text" style="border-radius: 10px; width: 101px;">No
                válidos</a>
        </td>
    `;
        for (let i = 0; i < notifications.length; i++) {


        }
    }
}
