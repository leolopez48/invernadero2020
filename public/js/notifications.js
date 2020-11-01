'use strict';

import Libs from './libs.js';

const lib = new Libs();

export default class Notification{

    getNotifications(url){
        fetch(url, {
            method: 'GET',
            mode: 'cors',
            cache: 'default'
        })
        .then((response) => response.json())
        .then((data) => {
            console.log(data)
            this.loadNotifications(data);
        });
    }

    loadNotifications(data) {
        const mob = document.getElementById('notificationMobile');
        const web = document.getElementById('notificationWeb');
        //lib.removeChilds(mob);
        //lib.removeChilds(web);

        let state;

        for (let i = 0; i < data.notification.length; i++) {
            let tr = document.createElement('tr');
            let photo = "https://picsum.photos/id/60/60";
            let title = "Invernadero";

            if(data.notification[i].state == 'Correcto'){
                state = 'green';
            }else{
                state = 'red';
            }

            for (let j = 0; j < data.stations.length; j++) {
                if(data.stations[j][0].id == data.notification[i].id){
                    photo = data.stations[j][0].photo;
                    title = data.stations[j][0].title;
                    break;
                }
            }

            tr.innerHTML = `
            <td class="center">
                <img style="border-radius:10px" style="padding-left:20px" src="${photo}" alt="" width="60px" height="60px">
            </td>
            <td>
                <strong>${title}</strong><br>
                Temp: ${data.notification[i].temperature.toFixed(2)}<br>
                Radiación: ${data.notification[i].radiation.toFixed(2)} <br>
                Humedad: ${data.notification[i].humidity.toFixed(2)}
                <a href="#" class="${state} white-text" style="border-radius: 10px; width: 101px;">${data.notification[i].state}</a>
            </td>
            `;

            mob.appendChild(tr);
            web.appendChild(tr);

        }
    }
}

// export {Notification};
