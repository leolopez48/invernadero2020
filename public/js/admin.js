const url = 'http://192.168.1.24:82/api/stations/';
const urlBase = 'http://192.168.1.24:82/';
// const url = 'http://localhost:8000/api/stations/';
// const urlBase = 'http://localhost:8000/';


//Listeners
document.getElementById('btnNew').addEventListener('click', (ev) => {
    ev.preventDefault();
    document.getElementById('titleModal').textContent = 'Nueva estación';
    resetForm();
    closeLoader();
});

document.addEventListener('DOMContentLoaded', (ev) => {
    loadStations();
});

document.getElementById('divStations').addEventListener('click', (ev) => {
    ev.preventDefault();

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

                deleteStation(data);
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
        getUsersAllowed(data);
    }
});

document.getElementById('saveStation').addEventListener('click', (ev) => {
    if (document.getElementById('titleModal').textContent === "Editar estación") {

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

        editStation(data);

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

        addStation(data);
    }
});

document.getElementById('inFile').addEventListener('change', (ev) => {
    loadPreview(ev);
});

document.getElementById('btnUserSearch').addEventListener('click', (ev)=>{
    ev.preventDefault();

    const email = document.getElementById('inUser').value;
    const id = document.getElementById('inId').textContent;
    const data = {
        idStation: id,
        email: email,
    }

    findUser(data);

});

document.getElementById('divUserSearched').addEventListener('click', (ev)=>{
    const id = document.getElementById('inId').textContent;
    const email = ev.target.parentNode.parentNode.parentNode.querySelector('#userEmail').firstChild.nodeValue;

    const data = {
        idStation: id,
        email: email
    }

    console.log(data)

    addUserStation(data, data);
});

document.getElementById('divUserAllowed').addEventListener('click', (ev)=>{
    if(ev.target.textContent == 'delete'){

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

                deleteUserSuscription(data, users);
            }
          })

    }
});

// END LISTENERS

//FUNCTIONS
function deleteUserSuscription(data, users){
    fetch(urlBase+'api/users/deleteSuscription', {
        method: 'POST',
        mode: 'cors',
        cache: 'default',
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        }
    }).then((response)=>{return response.json();})
    .then((data)=>{
        if(data.message == 'success'){
            message('¡Hecho!', 'Se ha eliminado este usuario.', 'success');
        }else{
            message('Error', 'No fue posible eliminar este usuario.', 'error');
        }
        getUsersAllowed(users);
    });
}

function getUsersAllowed(data){
    fetch(urlBase+'api/users/getSuscribed', {
        method: 'POST',
        mode: 'cors',
        cache: 'default',
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        }
    }).then((response)=>{return response.json();})
    .then((data)=>{
        removeChilds(document.getElementById('divUserAllowed'));
        showUser(data.users);
        console.log(data)
    });
}

function addUserStation(data, users){
    fetch(urlBase+'api/users/addStation', {
        method: 'POST',
        mode: 'cors',
        cache: 'default',
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        }
    }).then((response)=>{return response.json();})
    .then((data)=>{
        console.log(data)
        if(data.message == 'success'){
            message('¡Hecho!', 'Se ha agregado este usuario.', 'success');
        }else{
            message('Error', 'No fue posible agregar este usuario.', 'error');
        }
        removeChilds(document.getElementById('divUserSearched'));
        getUsersAllowed(users);
        document.getElementById('inUser').value = '';
    });
}

function showUserSearched(data){
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

function showUser(data){
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

function removeChilds(myNode){
    while (myNode.firstChild) {
      myNode.removeChild(myNode.lastChild);
    }
}

function findUser(data){
    fetch(urlBase+'api/users/get', {
        method: 'POST',
        mode: 'cors',
        cache: 'default',
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        }
    }).then((response)=>{return response.json();})
    .then((data)=>{
        if(data.message == 'User not found.'){
            message('¡Error!','Usuario no encontrado.', 'error');
        }
        else if(data.message == 'Station already added.'){
            message('Usuario registrado', data.user[0].name + ' ya ha sido asignado.', 'error');
        }else{
            showUserSearched(data.user);
        }
    });
}

function message(title, message, icon){
    Swal.fire(
        title,
        message,
        icon
      );
}

function addStation(data) {
    fetch(url + 'add', {
            method: 'POST',
            mode: 'cors',
            cache: 'default',
            body: data,
            headers: {
                'Accept': 'application/json',
                'Accept': 'image/jpg',
                'Accept': 'image/jpeg',
                'Accept': 'image/png'
            }
        }).then((response) => {
            return response.json();
        })
        .then((data) => {
            loadStations();
        });
}

function editStation(body) {
    fetch(url + 'edit', {
            method: 'POST',
            mode: 'cors',
            cache: 'default',
            body: body,
            headers: {
                'Accept': 'application/json',
                'Accept': 'image/jpg',
                'Accept': 'image/jpeg',
                'Accept': 'image/png'
            }
        })
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            console.log(data)
            loadStations();
        });
}

function deleteStation(body) {
    fetch(url + 'delete', {
            method: 'POST',
            mode: 'cors',
            cache: 'default',
            body: JSON.stringify(body),
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            loadStations();
        });
}

function loadStations() {
    cleanDivStations();
    openLoader();
    const enabled = {
        state: true,
        action: 'admin'
    }
    getData(enabled, "Habilitadas"); // Get enabled stations
    const disabled = {
        state: false,
        action: 'admin'
    }
    getData(disabled, "Deshabilitadas"); // Get disabled stations
    resetForm();
}

function getData(body, state) {
    fetch(url + 'get', {
            method: 'POST',
            mode: 'cors',
            cache: 'default',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(body)
        })
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            console.log(data)
            loadData(data.stations, state);
            if(data.typeAccess > 1){
                hideByAccess();
            }
        }).catch((error)=>{
            closeLoader();
        });
}

function hideByAccess(){
    document.getElementById('btnNewDiv').style.display = 'none';
}

function loadData(data, stationType) {
    const stations = document.getElementById('divStations');

    const div = document.createElement('div');
    div.classList.add('row');
    const title = document.createElement('h4');
    title.textContent = `${stationType}`;
    title.style.color = "white";
    title.style.textAlign = "left";

    div.appendChild(title);
    stations.appendChild(div);

    if (data.length > 0) {
        for (let i = 0; i < data.length; i++) {
            const station = document.createElement('div');
            station.innerHTML = `
            <div class="col s12 m3 l2 m-1 white rounded hoverable">
                <div class=" col s12 center">
                    <img class="circle center-align p-1" src="${data[i].photo}" width="130px" height="130px" alt="" id="photoStation">
                </div>
                <div class="col s12 center">
                    <p id="idStation" style="display:none">${data[i].id}</p>
                    <strong class="center black-text" id="titleStation">${data[i].title}</strong>
                    <p class="black-text p-1 left-align" id="descStation" >${data[i].description}</p>
                    <p class="black-text p-1 left-align" id="humidityL" style="display:none;">${data[i].humidity}</p>
                    <p class="black-text p-1 left-align" id="temperatureL" style="display:none;">${data[i].temperature}</p>
                    <p class="black-text p-1 left-align" id="radiationL" style="display:none;">${data[i].radiation}</p>
                </div>
                <div class="col s12 center m-1">
                    <a class="station modal-trigger btn blue a-edit" id="btnEdit" href="#modal1">
                        <i class="material-icons edit">edit</i>
                    </a>
                    <a class="station btn red a-delete" id="btnDelete" href="">
                        <i class="material-icons delete">delete</i>
                    </a>
                </div>
            </div>
            `;
            div.appendChild(station);

        }
    } else {
        const stationMessage = document.createElement('h6');
        stationMessage.textContent = `No hay estaciones ${stationType.toLowerCase()}`;
        stationMessage.style.color = "white";
        stationMessage.style.textAlign = "left";
        stations.appendChild(stationMessage);
    }
    closeLoader();
}

function resetForm() {
    document.getElementById('inPhotoPre').src = `${urlBase}default/no-image.png`;
    document.getElementById('inPhotoPre').value = "";

    document.getElementById('inFile').value = "";
    document.getElementById('inName').value = "";
    document.getElementById('inDescription').value = "";

    document.getElementById('inLowestPH').value = "";
    document.getElementById('inLowestPT').value = "";
    document.getElementById('inLowestPR').value = "";
}

function loadPreview(ev) {
    let preview = document.getElementById('inPhotoPre');
    let file = document.getElementById('inFile');
    preview.src = URL.createObjectURL(ev.target.files[0]);
    preview.onload = function () {
        URL.revokeObjectURL(preview.src) // free memory
    }
}

function sendData(type, data) {
    fetch(url + type, {
            method: 'POST',
            mode: 'cors',
            cache: 'default'
        }).then((response) => response.json())
        .then((data) => {
            console.log(data);
        })
        .catch((error) => {
            console.log("Error: " + error.message);
        });
}

function evaluateState(ev) {
    let state;
    if (ev.target.parentNode.parentNode.parentNode.parentNode.firstChild.textContent.toString() == "Habilitadas") {
        state = {
            state: "habilitará",
            action: "Habilitar"
        }
    } else {
        state = {
            state: "deshabilitará",
            action: "Deshabilitar"
        }
    }
    return state;
}
// END FUNCTION

// CSS FUNCTIONS
function closeLoader() {
    document.getElementById('loader').style.display = 'none';
    document.getElementById('loader-toggle').classList.remove('active');
}

function openLoader() {
    document.getElementById('loader-toggle').classList.add('active');
}

function cleanDivStations() {
    $('#divStations').empty();
}
// END CSS FUNCTIONS
