import Notification from './notifications.js';

const url = 'http://192.168.1.24:8000/api/stations/';
const urlBase = 'http://192.168.1.24:8000/';
// const url = 'http://localhost:8000/api/notifications/';
// const urlBase = 'http://localhost:8000/';
// const url = 'http://192.168.1.21/api/notifications/';
// const urlBase = 'http://192.168.1.21/';

let not = new Notification();

document.addEventListener('DOMContentLoaded', (ev) => {
    not.getNotifications(urlBase + 'api/notifications/get');
});
