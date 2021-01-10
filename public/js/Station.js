import Libs from "./Libs.js";

const lib = new Libs();

// const url = 'http://localhost:8000/api/stations/';
// const urlBase = 'http://localhost:8000/';
const url = 'http://192.168.1.21/api/stations/';
const urlBase = 'http://192.168.1.21/';

export default class Station {

    /*
        Envía los datos de la nueva estación que se creará.
    */
    addStation(data) {
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
                console.log(data)
                const st = new Station();
                st.loadStations();
            }).catch((error) => {
                console.log(error);
            });
    }

    /*
        Obtiene los registros de la estación que se desee.
    */
    getData(body, state) {
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
                const st = new Station();
                st.loadData(data.stations, state);
                if (data.typeAccess > 1) {
                    lib.hideByAccess();
                }
            }).catch((error) => {
                console.log("Error: " + error)
                lib.closeLoader();
            });
    }

    /*
        Realiza la petición para editar los datos de la estación que se desee.
    */
    editStation(body) {
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
                const st = new Station();
                st.loadStations();
                lib.message('Estación actualizada.', '', 'success')
            }).catch((error) => {
                console.log("Error: " + error)
                lib.closeLoader();
            });
    }

    /*
        Realiza la petición para deshabilitar una estación específica.
    */
    deleteStation(body) {
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
                const st = new Station();
                st.loadStations();
            }).catch((error) => {
                console.log("Error: " + error)
                lib.closeLoader();
            });
    }

    /*
        Carga las estaciones dependiendo del estado que se indique; ya sean,
        las estaciones habilitadas o deshabilitadas.
    */
    loadStations() {
        lib.cleanDivStations();
        lib.openLoader();
        const enabled = {
            state: true,
            action: 'admin'
        }
        this.getData(enabled, "Habilitadas"); // Get enabled stations
        const disabled = {
            state: false,
            action: 'admin'
        }
        this.getData(disabled, "Deshabilitadas"); // Get disabled stations
        lib.resetForm();
    }

    /*
        Crea las estaciones dinámicamente dependiendo de los datos recibidos en la petición.
    */
    loadData(data, stationType) {
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
                    <div class="col s12 m12 center">
                        <p id="idStation" style="display:none">${data[i].id}</p>
                        <strong class="center black-text" id="titleStation">${data[i].title}</strong>
                        <p class="black-text p-1 left-align" id="descStation" >${data[i].description}</p>
                        <p class="black-text p-1 left-align" id="humidityL" style="display: none;">${data[i].humidity}</p>
                        <p class="black-text p-1 left-align" id="temperatureL" style="display: none;">${data[i].temperature}</p>
                        <p class="black-text p-1 left-align" id="radiationL" style="display: none;">${data[i].radiation}</p>
                        <p class="black-text p-1 left-align" id="phL" style="display: none;">${data[i].ph}</p>
                        <p class="black-text p-1 left-align" id="oxigenL" style="display: none;">${data[i].oxigen}</p>
                        <p class="black-text p-1 left-align" id="humidityM" style="display: none;">${data[i].humidityM}</p>
                        <p class="black-text p-1 left-align" id="temperatureM" style="display: none;">${data[i].temperatureM}</p>
                        <p class="black-text p-1 left-align" id="radiationM" style="display: none;">${data[i].radiationM}</p>
                        <p class="black-text p-1 left-align" id="phM" style="display: none;">${data[i].phM}</p>
                        <p class="black-text p-1 left-align" id="oxigenM" style="display: none;">${data[i].oxigenM}</p>
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
        lib.closeLoader();
    }

    sendData(type, data) {
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

    /*
    Verifica si la estación se habilitará o deshabilitará.
    */
    evaluateState(ev) {
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

}
