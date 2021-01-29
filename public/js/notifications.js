'use strict';

import Libs from './Libs.js';

const lib = new Libs();

// const url = 'http://localhost:8000/api/stations/';
// const urlBase = 'http://localhost:8000/';
const url = 'http://192.168.1.24:8000/api/stations/';
const urlBase = 'http://192.168.1.24:8000/';

export default class Notification {

    /*
        Realiza la petición a la API habilitada para obtener las notificaciones.
    */
    getNotifications(url) {
        fetch(url, {
                method: 'GET',
                mode: 'cors',
                cache: 'default'
            })
            .then((response) => response.json())
            .then((data) => {
                const mob = document.getElementById('notificationMobile');
                this.loadNotifications(data, mob);
                const web = document.getElementById('notificationWeb');
                this.loadNotifications(data, web);
            });
    }

    /*
        Crea las notificaciones con sus datos respectivos.
    */
    loadNotifications(data, div) {
        lib.removeChilds(div);

        let state;
        let string;

        for (let i = 0; i < data.notification.length; i++) {
            let tr = document.createElement('tr');
            let photo = "https://picsum.photos/id/60/60";
            let title = "Invernadero";

            if (data.notification[i].state == 'Válido') {
                state = 'green';
            } else {
                state = 'red';
            }

            for (let j = 0; j < data.stations.length; j++) {
                if (data.stations[j][0].id == data.notification[i].id) {
                    photo = data.stations[j][0].photo;
                    title = data.stations[j][0].title;
                    break;
                }
            }

            string = `
            <td class="center">
                <img style="border-radius:10px" style="padding-left:10px" src="${photo}" alt="" width="60px" height="60px">
            </td>
            <td class="black-text" style="height:100px; ">
                <strong>${title}</strong><br>`;

            if (data.notification[i].temperature) {
                string += `Temperatura: ${parseInt(data.notification[i].temperature).toFixed(2)}<br>`;
            }
            if (data.notification[i].humidity) {
                string += `Húmedad: ${parseInt(data.notification[i].humidity).toFixed(2)}<br>`;
            }
            if (data.notification[i].radiation) {
                string += `Radiación: ${parseInt(data.notification[i].radiation).toFixed(2)}<br>`;
            }
            if (data.notification[i].ph) {
                string += `PH: ${parseInt(data.notification[i].ph).toFixed(2)}<br>`;
            }
            if (data.notification[i].oxigen) {
                string += `Nivel Oxígeno: ${parseInt(data.notification[i].oxigen).toFixed(2)}<br>`;
            }
            string += `<a href="#" class="${state} white-text" style="border-radius: 10px; width: 101px;">${data.notification[i].state}</a>
            </td>`;

            tr.innerHTML = string;

            div.appendChild(tr);

        }
    }
}

// export {Notification};
