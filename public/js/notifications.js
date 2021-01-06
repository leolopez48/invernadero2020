'use strict';

import Libs from './libs.js';

const lib = new Libs();

const url = 'http://localhost:8000/api/stations/';
const urlBase = 'http://localhost:8000/';

export default class Notification {

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

    loadNotifications(data, div) {
        lib.removeChilds(div);

        let state;
        let string;

        for (let i = 0; i < data.notification.length; i++) {
            let tr = document.createElement('tr');
            let photo = "https://picsum.photos/id/60/60";
            let title = "Invernadero";

            if (data.notification[i].state == 'Correcto') {
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
                <img style="border-radius:10px" style="padding-left:20px" src="${photo}" alt="" width="60px" height="60px">
            </td>
            <td>
                <strong>${title}</strong><br>`;

            if (data.notification[i].temperature) {
                string += `Temp: ${parseInt(data.notification[i].temperature).toFixed(2)}<br>`;
            }
            if (data.notification[i].humidity) {
                string += `Temp: ${parseInt(data.notification[i].humidity).toFixed(2)}<br>`;
            }
            if (data.notification[i].radiation) {
                string += `Temp: ${parseInt(data.notification[i].radiation).toFixed(2)}<br>`;
            }
            if (data.notification[i].ph) {
                string += `Temp: ${parseInt(data.notification[i].ph).toFixed(2)}<br>`;
            }
            if (data.notification[i].oxigen) {
                string += `Temp: ${parseInt(data.notification[i].oxigen).toFixed(2)}<br>`;
            }
            string += `<a href="#" class="${state} white-text" style="border-radius: 10px; width: 101px;">${data.notification[i].state}</a>
            </td>`;

            tr.innerHTML = string;
            /*`
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
            `;*/

            div.appendChild(tr);

        }
    }
}

// export {Notification};
