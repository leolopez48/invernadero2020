import Notification from './notifications.js';

// const url = 'http://192.168.1.24:82/api/stations/';
// const urlBase = 'http://192.168.1.24:82/';
const url = 'http://localhost:8000/api/notifications/';
const urlBase = 'http://localhost:8000/';

let not = new Notification();

document.addEventListener('DOMContentLoaded', (ev) => {
    not.getNotifications(urlBase + 'api/notifications/get');
});
