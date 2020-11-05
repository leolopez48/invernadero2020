import Station from './Station.js';
import Libs from './Libs.js';
import User from './User.js';

const url = 'http://localhost:8000/api/stations/';
const urlBase = 'http://localhost:8000/';

const user = new User();
const station = new Station();
const lib = new Libs();

//Listeners
document.getElementById('btnNew').addEventListener('click', (ev) => {
    ev.preventDefault();
    document.getElementById('titleModal').textContent = 'Nueva estación';
    lib.resetForm();
    lib.closeLoader();
    document.getElementById('divSearch').style.display = 'none';
});

document.addEventListener('DOMContentLoaded', (ev) => {
    station.loadStations();
});

document.getElementById('divStations').addEventListener('click', (ev) => {
    ev.preventDefault();
    document.getElementById('divSearch').style.display = 'initial';
    if (ev.target.classList[1] === 'delete' || ev.target.classList[3] === 'a-delete') {
        let id = ev.target.parentNode.parentNode.parentNode.querySelector("#idStation").firstChild.nodeValue.toString();
        let state = "";
        let action = "";
        let mensaje = "";

        if (ev.target.classList[1] == 'delete') {
            const section = ev.target.parentNode.parentNode.parentNode.parentNode.parentNode.firstChild.textContent;
            if (section == "Deshabilitadas") {
                state = "habilitará";
                action = "Habilitar";
                mensaje = "Habilitada";
            } else if (section == "Habilitadas") {
                state = "deshabilitará";
                action = "Deshabilitar";
                mensaje = "Deshabilitada";
            }
        } else if (ev.target.classList[3] === 'a-delete') {
            const section = ev.target.parentNode.parentNode.parentNode.parentNode.firstChild.textContent;
            if (section == "Deshabilitadas") {
                state = "habilitará";
                action = "Habilitar";
                mensaje = "Habilitada";
            } else if (section == "Habilitadas") {
                state = "deshabilitará";
                action = "Deshabilitar";
                mensaje = "Deshabilitada";
            }
        }

        Swal.fire({
            title: '¿Estás seguro?',
            text: `Esta acción ${state} la estación.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: action
        }).then((result) => {
            if (result.value) {

                const data = {
                    id: id
                }

                station.deleteStation(data);
                Swal.fire(
                    `¡${mensaje}!`,
                    `La estación ha sido ${mensaje.toLowerCase()}.`,
                    'success'
                )
            }
        })
    }

    if (ev.target.classList[1] === 'edit' || ev.target.classList[4] === 'a-edit') {
        ev.preventDefault();
        let id = 0;

        document.getElementById('titleModal').textContent = 'Editar estación';
        if (ev.target.classList[1] === 'edit') {
            id = ev.target.parentNode.parentNode.parentNode.querySelector("#idStation").firstChild.nodeValue;
            const title = ev.target.parentNode.parentNode.parentNode.querySelector("#titleStation").firstChild.nodeValue;
            const desc = ev.target.parentNode.parentNode.parentNode.querySelector("#descStation").firstChild.nodeValue;
            const photo = ev.target.parentNode.parentNode.parentNode.querySelector("#photoStation").src;
            const humidity = ev.target.parentNode.parentNode.parentNode.querySelector("#humidityL").firstChild.nodeValue;
            const temperature = ev.target.parentNode.parentNode.parentNode.querySelector("#temperatureL").firstChild.nodeValue;
            const radiation = ev.target.parentNode.parentNode.parentNode.querySelector("#radiationL").firstChild.nodeValue;

            document.getElementById('inId').textContent = id;
            document.getElementById('inPhotoPre').src = photo;
            document.getElementById('inName').value = title;
            document.getElementById('inDescription').value = desc;
            document.getElementById('inLowestPH').value = humidity;
            document.getElementById('inLowestPR').value = radiation;
            document.getElementById('inLowestPT').value = temperature;

        } else {
            id = ev.target.parentNode.parentNode.querySelector("#idStation").firstChild.nodeValue;
            const title = ev.target.parentNode.parentNode.querySelector("#titleStation").firstChild.nodeValue;
            const desc = ev.target.parentNode.parentNode.querySelector("#descStation").firstChild.nodeValue;
            const photo = ev.target.parentNode.parentNode.querySelector("#photoStation").src;
            const humidity = ev.target.parentNode.parentNode.querySelector("#humidityL").firstChild.nodeValue;
            const temperature = ev.target.parentNode.parentNode.querySelector("#temperatureL").firstChild.nodeValue;
            const radiation = ev.target.parentNode.parentNode.querySelector("#radiationL").firstChild.nodeValue;

            document.getElementById('inId').textContent = id;
            document.getElementById('inPhotoPre').src = photo;
            document.getElementById('inName').value = title;
            document.getElementById('inDescription').value = desc;
            document.getElementById('inLowestPH').value = humidity;
            document.getElementById('inLowestPR').value = radiation;
            document.getElementById('inLowestPT').value = temperature;
        }

        const data = {
            idStation: id
        }
        user.getUsersAllowed(data);
    }
});

document.getElementById('saveStation').addEventListener('click', (ev) => {
    if (document.getElementById('titleModal').textContent === "Editar estación") {

        document.getElementById('divSearch').style.display = 'initial';

        const id = document.getElementById('inId').textContent;
        const name = document.getElementById('inName').value;
        const desc = document.getElementById('inDescription').value;
        const temperature = document.getElementById('inLowestPT').value;
        const humidity = document.getElementById('inLowestPH').value;
        const radiation = document.getElementById('inLowestPR').value;

        const data = new FormData();
        data.append('id', id);
        data.append('title', name);
        data.append('description', desc);
        data.append('humidity', humidity);
        data.append('temperature', temperature);
        data.append('radiation', radiation);

        if (document.getElementById('inFile').files[0] !== undefined) {
            const photo = document.getElementById('inFile');
            data.append('photo', photo.files[0]);
        }

        station.editStation(data);

    } else if (document.getElementById('titleModal').textContent === "Nueva estación") {
        const photo = document.getElementById('inFile');
        const name = document.getElementById('inName').value;
        const desc = document.getElementById('inDescription').value;
        const temperature = document.getElementById('inLowestPT').value;
        const humidity = document.getElementById('inLowestPH').value;
        const radiation = document.getElementById('inLowestPR').value;

        const data = new FormData();
        data.append('photo', photo.files[0]);
        data.append('title', name);
        data.append('description', desc);
        data.append('humidity', humidity);
        data.append('temperature', temperature);
        data.append('radiation', radiation);

        station.addStation(data);
    }
});

document.getElementById('inFile').addEventListener('change', (ev) => {
    lib.loadPreview(ev);
});

document.getElementById('btnUserSearch').addEventListener('click', (ev) => {
    ev.preventDefault();

    const email = document.getElementById('inUser').value;
    const id = document.getElementById('inId').textContent;
    const data = {
        idStation: id,
        email: email,
    }

    user.findUser(data);

});

document.getElementById('divUserSearched').addEventListener('click', (ev) => {
    const id = document.getElementById('inId').textContent;
    const email = ev.target.parentNode.parentNode.parentNode.querySelector('#userEmail').firstChild.nodeValue;

    const data = {
        idStation: id,
        email: email
    }

    user.addUserStation(data, data);
});

document.getElementById('divUserAllowed').addEventListener('click', (ev) => {
    if (ev.target.textContent == 'delete') {

        Swal.fire({
            icon: 'warning',
            title: '¿Deseas eliminar a este usuario?',
            text: 'Esta acción no se puede deshacer.',
            showCancelButton: true,
            confirmButtonText: `Eliminar`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = ev.target.parentNode.parentNode.parentNode.parentNode.
                parentNode.parentNode.parentNode.parentNode.querySelector('#inId').firstChild.nodeValue;

                const email = ev.target.parentNode.parentNode.parentNode.querySelector('#userEmail').firstChild.nodeValue;

                const data = {
                    idStation: id,
                    email: email,
                }

                const users = {
                    idStation: id
                }

                user.deleteUserSuscription(data, users);
            }
        })
    }
});
// END LISTENERS
