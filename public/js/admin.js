const url = 'http://localhost:8000/api/stations/';

//Listeners
document.getElementById('btnNew').addEventListener('click', (ev) => {
    ev.preventDefault();
    document.getElementById('titleModal').textContent = 'Nueva estación';
    resetForm();
    closeLoader();
});

document.addEventListener('DOMContentLoaded', (ev) => {
    openLoader();
    const enabled = {
        state: true
    }
    getData(enabled, "Habilitadas"); // Get enabled stations
    const disabled = {
        state: false
    }
    getData(disabled, "Deshabilitadas"); // Get disabled stations

});

document.getElementById('divStations').addEventListener('click', (ev) => {
    ev.preventDefault();

    if (ev.target.classList[1] === 'delete' || ev.target.classList[3] === 'a-delete') {
        let id = ev.target.parentNode.parentNode.parentNode.querySelector("#idStation").firstChild.nodeValue.toString();

        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción deshabilitará la estación.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Deshabilitar'
        }).then((result) => {
            if (result.value) {

                const data = {
                    id: id
                }

                deleteStation(data);
                Swal.fire(
                    '¡Deshabilitada!',
                    'La estación ha sido deshabilitada.',
                    'success'
                )
            }
        })
    }

    if (ev.target.classList[1] === 'edit' || ev.target.classList[4] === 'a-edit') {
        ev.preventDefault();
        loadStationModal(ev);
        document.getElementById('titleModal').textContent = 'Editar estación';
        if (ev.target.classList[1] === 'edit') {
            const id = ev.target.parentNode.parentNode.parentNode.querySelector("#idStation").firstChild.nodeValue;
            const title = ev.target.parentNode.parentNode.parentNode.querySelector("#titleStation").firstChild.nodeValue;
            const desc = ev.target.parentNode.parentNode.parentNode.querySelector("#descStation").firstChild.nodeValue;
            const photo = ev.target.parentNode.parentNode.parentNode.querySelector("#photoStation").src;

            document.getElementById('inId').textContent = id;
            document.getElementById('inPhotoPre').src = photo;
            document.getElementById('inName').value = title;
            document.getElementById('inDescription').value = desc;

        } else {
            const id = ev.target.parentNode.parentNode.querySelector("#idStation").firstChild.nodeValue;
            const title = ev.target.parentNode.parentNode.querySelector("#titleStation").firstChild.nodeValue;
            const desc = ev.target.parentNode.parentNode.querySelector("#descStation").firstChild.nodeValue;
            const photo = ev.target.parentNode.parentNode.querySelector("#photoStation").src;

            document.getElementById('inId').textContent = id;
            document.getElementById('inPhotoPre').src = photo;
            document.getElementById('inName').value = title;
            document.getElementById('inDescription').value = desc;
        }
    }
});

document.getElementById('saveStation').addEventListener('click', (ev) => {
    if (document.getElementById('titleModal').textContent === "Editar estación") {

        const id = document.getElementById('inId').textContent;
        const photo = document.getElementById('inPhotoPre').src;
        const name = document.getElementById('inName').value;
        const desc = document.getElementById('inDescription').value;

        const data = {
            id: id,
            photo: photo,
            name: name,
            desc: desc
        }

        editStation(data);

    } else if (document.getElementById('titleModal').textContent === "Nueva estación") {

    }
});

// END LISTENERS

//FUNCTIONS
function editStation(body) {
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
            console.log(data);
        });
}

function deleteStation(body) {
    console.log(body)
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
            openLoader();
            cleanDivStations();
            const enabled = {
                state: true
            }
            getData(enabled, "Habilitadas"); // Get enabled stations
            const disabled = {
                state: false
            }
            getData(disabled, "Deshabilitadas"); // Get disabled stations
        });
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
            loadData(data, state);
        });
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
                    <img class="circle center-align p-1" src="https://picsum.photos/id/110/110/110" alt="" id="photoStation">
                </div>
                <div class="col s12 center">
                    <p id="idStation" style="display:none">${data[i].id}</p>
                    <strong class="center black-text" id="titleStation">${data[i].title}</strong>
                    <p class="black-text p-1 left-align" id="descStation">${data[i].description}</p>
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

function loadStationModal(ev) {
    // console.log(ev.target.parentNode)
    // while (ev.path[0] !== 'div.col.s12.m3.l2.m-1.white.rounded.hoverable') {
    //     ev.parentNode;
    //     console.log("no")
    // }
}

function resetForm() {
    document.getElementById('inFile').value = "";
    document.getElementById('inName').value = "";
    document.getElementById('inDescription').value = "";
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
// END FUNCTION

// LOADER
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
// END LOADER
