import Libs from './Libs.js';

const lib = new Libs();

const url = 'http://localhost:8000/api/stations/';
const urlBase = 'http://localhost:8000/';

export default class User {

    getUsersAllowed(data) {
        fetch(urlBase + 'api/users/getSuscribed', {
                method: 'POST',
                mode: 'cors',
                cache: 'default',
                body: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                }
            }).then((response) => {
                return response.json();
            })
            .then((data) => {
                const us = new User();
                lib.removeChilds(document.getElementById('divUserAllowed'));
                us.showUser(data.users);
            });
    }

    addUserStation(data, users) {
        fetch(urlBase + 'api/users/addStation', {
                method: 'POST',
                mode: 'cors',
                cache: 'default',
                body: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                }
            }).then((response) => {
                return response.json();
            })
            .then((data) => {
                const us = new User();

                if (data.message == 'success') {
                    lib.message('¡Hecho!', 'Se ha agregado este usuario.', 'success');
                } else {
                    lib.message('Error', 'No fue posible agregar este usuario.', 'error');
                }

                lib.removeChilds(document.getElementById('divUserSearched'));
                us.getUsersAllowed(users);
                document.getElementById('inUser').value = '';

            }).catch((error) => {
                console.log("Error: " + error)
            });;
    }

    showUserSearched(data) {
        const divUserSearched = document.getElementById('divUserSearched');
        const user = document.createElement('div');
        user.innerHTML = `
        <div class="col s9">
            <h6>${data[0].name}</h6>
            <p id="userEmail">${data[0].email}</p>
        </div>
        <div class="col s3" style="padding-top: 10px;">
            <a href="#" class="btn blue add-user"><i class="material-icons">add</i></a>
        </div>
        `;
        divUserSearched.appendChild(user);
    }

    showUser(data) {
        const divUserSearched = document.getElementById('divUserAllowed');
        for (let i = 0; i < data.length; i++) {
            const user = document.createElement('div');
            user.innerHTML = `
                <div id="user">
                    <div class="col s9">
                        <h6>${data[i].name}</h6>
                        <p id="userEmail">${data[i].email}</p>
                    </div>
                    <div class="col s3" style="padding-top: 10px;">
                        <a href="#" class="btn red"><i class="material-icons">delete</i></a>
                    </div>
                </div>
            `;
            divUserSearched.appendChild(user);
        }

    }

    deleteUserSuscription(data, users) {
        fetch(urlBase + 'api/users/deleteSuscription', {
                method: 'POST',
                mode: 'cors',
                cache: 'default',
                body: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                }
            }).then((response) => {
                return response.json();
            })
            .then((data) => {
                if (data.message == 'success') {
                    lib.message('¡Hecho!', 'Se ha eliminado este usuario.', 'success');
                } else {
                    lib.message('Error', 'No fue posible eliminar este usuario.', 'error');
                }
                this.getUsersAllowed(users);
            });
    }

    findUser(data) {
        fetch(urlBase + 'api/users/get', {
                method: 'POST',
                mode: 'cors',
                cache: 'default',
                body: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                }
            }).then((response) => {
                return response.json();
            })
            .then((data) => {
                console.log(data)
                const us = new User();
                if (data.message == 'User not found.') {
                    lib.message('¡Error!', 'Usuario no encontrado.', 'error');
                } else if (data.message == 'Station already added.') {
                    lib.message('Usuario registrado', data.user[0].name + ' ya ha sido asignado.', 'error');
                } else {
                    us.showUserSearched(data.user);
                }
            });
    }
}
