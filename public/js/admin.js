import Station from './Station.js';
import Libs from './Libs.js';
import User from './User.js';

const url = 'http://localhost:8000/api/stations/';
const urlBase = 'http://localhost:8000/';
let typeStation = "";
//MinValues
//Invernadero
let minTemperature = false;
let minHumidity = false;
let minRadiation = false;
//Acuícola
let minPh = false;
let minOxigen = false;

//Max values
//Invernadero
let maxTemperature = false;
let maxHumidity = false;
let maxRadiation = false;
//Acuícola
let maxPh = false;
let maxOxigen = false;

const user = new User();
const station = new Station();
const lib = new Libs();

//Listeners
document.getElementById('btnNew').addEventListener('click', (ev) => {
    ev.preventDefault();
    document.getElementById('titleModal').textContent = 'Nueva estación';
    lib.resetForm();
    lib.closeLoader();
    document.getElementById('divSearch').style.display = 'initial';
});

document.addEventListener('DOMContentLoaded', (ev) => {
    station.loadStations();
    lib.hideInputsBoolean(true);
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
        const divMinBtnsInv = document.getElementById('minValueButtonsInv');
        const divMinBtnsAcu = document.getElementById('minValueButtonsAcu');

        divMinBtnsInv.style.display = 'none';
        divMinBtnsAcu.style.display = 'none';

        document.getElementById('titleModal').textContent = 'Editar estación';
        if (ev.target.classList[1] === 'edit') {
            id = ev.target.parentNode.parentNode.parentNode.querySelector("#idStation").firstChild.nodeValue;
            const title = ev.target.parentNode.parentNode.parentNode.querySelector("#titleStation").firstChild.nodeValue;
            const desc = ev.target.parentNode.parentNode.parentNode.querySelector("#descStation").firstChild.nodeValue;
            const photo = ev.target.parentNode.parentNode.parentNode.querySelector("#photoStation").src;
            const humidity = ev.target.parentNode.parentNode.parentNode.querySelector("#humidityL").firstChild.nodeValue;
            const temperature = ev.target.parentNode.parentNode.parentNode.querySelector("#temperatureL").firstChild.nodeValue;
            const radiation = ev.target.parentNode.parentNode.parentNode.querySelector("#radiationL").firstChild.nodeValue;
            const ph = ev.target.parentNode.parentNode.parentNode.querySelector("#phL").firstChild.nodeValue;
            const oxigen = ev.target.parentNode.parentNode.parentNode.querySelector("#oxigenL").firstChild.nodeValue;
            const humidityM = ev.target.parentNode.parentNode.parentNode.querySelector("#humidityM").firstChild.nodeValue;
            const temperatureM = ev.target.parentNode.parentNode.parentNode.querySelector("#temperatureM").firstChild.nodeValue;
            const radiationM = ev.target.parentNode.parentNode.parentNode.querySelector("#radiationM").firstChild.nodeValue;
            const phM = ev.target.parentNode.parentNode.parentNode.querySelector("#phM").firstChild.nodeValue;
            const oxigenM = ev.target.parentNode.parentNode.parentNode.querySelector("#oxigenM").firstChild.nodeValue;

            document.getElementById('inId').textContent = id;
            document.getElementById('inPhotoPre').src = photo;
            document.getElementById('inName').value = title;
            document.getElementById('inDescription').value = desc;
            document.getElementById('inLowestPH').value = humidity;
            document.getElementById('inLowestPHL').value = ph;
            document.getElementById('inLowestOX').value = oxigen;
            document.getElementById('inLowestPR').value = radiation;
            document.getElementById('inLowestPT').value = temperature;
            document.getElementById('inHighestPH').value = humidityM;
            document.getElementById('inHighestPR').value = radiationM;
            document.getElementById('inHighestPT').value = temperatureM;
            document.getElementById('inHighestPHL').value = phM;
            document.getElementById('inHighestOX').value = oxigenM;

            document.getElementById('divInputsLow').style.display = 'initial';
            document.getElementById('divVar').style.display = 'initial';

            if (document.getElementById('inLowestPH').value === "") {
                document.getElementById('divLowHum').style.display = 'none';
                document.getElementById('divHighHum').style.display = 'none';
            } else {
                document.getElementById('divLowHum').style.display = 'initial';
                document.getElementById('divHighHum').style.display = 'initial';
            }

            if (document.getElementById('inLowestPT').value === "") {
                document.getElementById('divLowTemp').style.display = 'none';
                document.getElementById('divHighTemp').style.display = 'none';
            } else {
                document.getElementById('divLowTemp').style.display = 'initial';
                document.getElementById('divHighTemp').style.display = 'initial';
            }

            if (document.getElementById('inLowestPHL').value === "") {
                document.getElementById('divLowPHL').style.display = 'none';
                document.getElementById('divHighPHL').style.display = 'none';
            } else {
                document.getElementById('divLowPHL').style.display = 'initial';
                document.getElementById('divHighPHL').style.display = 'initial';
            }

            if (document.getElementById('inLowestPR').value === "") {
                document.getElementById('divLowRad').style.display = 'none';
                document.getElementById('divHighRad').style.display = 'none';
            } else {
                document.getElementById('divLowRad').style.display = 'initial';
                document.getElementById('divHighRad').style.display = 'initial';
            }

            if (document.getElementById('inLowestPH').value != "" || document.getElementById('inLowestPR').value != "") {
                document.getElementById('btnTypeAcu').style.display = 'none';
                document.getElementById('btnTypeInv').style.display = 'initial';
                typeStation = 'Invernadero';
                // console.log('invernadero')
            }

            if (document.getElementById('inLowestPHL').value != "" || document.getElementById('inLowestOX').value != "") {
                document.getElementById('btnTypeAcu').style.display = 'initial';
                document.getElementById('btnTypeInv').style.display = 'none';
                typeStation = 'Acuicola';
                // console.log('Acuicola')
            }

        } else {
            id = ev.target.parentNode.parentNode.querySelector("#idStation").firstChild.nodeValue;
            const title = ev.target.parentNode.parentNode.querySelector("#titleStation").firstChild.nodeValue;
            const desc = ev.target.parentNode.parentNode.querySelector("#descStation").firstChild.nodeValue;
            const photo = ev.target.parentNode.parentNode.querySelector("#photoStation").src;
            const humidity = ev.target.parentNode.parentNode.querySelector("#humidityL").firstChild.nodeValue;
            const temperature = ev.target.parentNode.parentNode.querySelector("#temperatureL").firstChild.nodeValue;
            const radiation = ev.target.parentNode.parentNode.querySelector("#radiationL").firstChild.nodeValue;
            const ph = ev.target.parentNode.parentNode.querySelector("#phL").firstChild.nodeValue;
            const oxigen = ev.target.parentNode.parentNode.querySelector("#oxigenL").firstChild.nodeValue;
            const humidityM = ev.target.parentNode.parentNode.querySelector("#humidityM").firstChild.nodeValue;
            const temperatureM = ev.target.parentNode.parentNode.querySelector("#temperatureM").firstChild.nodeValue;
            const radiationM = ev.target.parentNode.parentNode.querySelector("#radiationM").firstChild.nodeValue;
            const phM = ev.target.parentNode.parentNode.querySelector("#phM").firstChild.nodeValue;
            const oxigenM = ev.target.parentNode.parentNode.querySelector("#oxigenM").firstChild.nodeValue;

            document.getElementById('inId').textContent = id;
            document.getElementById('inPhotoPre').src = photo;
            document.getElementById('inName').value = title;
            document.getElementById('inDescription').value = desc;
            document.getElementById('inLowestPH').value = humidity;
            document.getElementById('inLowestPHL').value = ph;
            document.getElementById('inLowestOX').value = oxigen;
            document.getElementById('inLowestPR').value = radiation;
            document.getElementById('inLowestPT').value = temperature;
            document.getElementById('inHighestPH').value = humidityM;
            document.getElementById('inHighestPR').value = radiationM;
            document.getElementById('inHighestPT').value = temperatureM;
            document.getElementById('inHighestPHL').value = phM;
            document.getElementById('inHighestOX').value = oxigenM;

            document.getElementById('divInputsLow').style.display = 'initial';
            document.getElementById('divVar').style.display = 'initial';

            if (document.getElementById('inLowestPH').value === "") {
                document.getElementById('divLowHum').style.display = 'none';
                document.getElementById('divHighHum').style.display = 'none';
            } else {
                document.getElementById('divLowHum').style.display = 'initial';
                document.getElementById('divHighHum').style.display = 'initial';
            }

            if (document.getElementById('inLowestPT').value === "") {
                document.getElementById('divLowTemp').style.display = 'none';
                document.getElementById('divHighTemp').style.display = 'none';
            } else {
                document.getElementById('divLowTemp').style.display = 'initial';
                document.getElementById('divHighTemp').style.display = 'initial';
            }

            if (document.getElementById('inLowestPHL').value === "") {
                document.getElementById('divLowPHL').style.display = 'none';
                document.getElementById('divHighPHL').style.display = 'none';
            } else {
                document.getElementById('divLowPHL').style.display = 'initial';
                document.getElementById('divHighPHL').style.display = 'initial';
            }

            if (document.getElementById('inLowestPR').value === "") {
                document.getElementById('divLowRad').style.display = 'none';
                document.getElementById('divHighRad').style.display = 'none';
            } else {
                document.getElementById('divLowRad').style.display = 'initial';
                document.getElementById('divHighRad').style.display = 'initial';
            }

            if (document.getElementById('inLowestPH').value != "" || document.getElementById('inLowestPR').value != "") {
                document.getElementById('btnTypeAcu').style.display = 'none';
                document.getElementById('btnTypeInv').style.display = 'initial';
                // console.log('invernadero')
            }

            if (document.getElementById('inLowestPHL').value != "" || document.getElementById('inLowestOX').value != "") {
                document.getElementById('btnTypeAcu').style.display = 'initial';
                document.getElementById('btnTypeInv').style.display = 'none';
                // console.log('Acuicola')
            }
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

        //Greenhouse
        const temperature = document.getElementById('inLowestPT').value;
        const humidity = document.getElementById('inLowestPH').value;
        const radiation = document.getElementById('inLowestPR').value;
        const maxTemperature = document.getElementById('inHighestPT').value;
        const maxHumidity = document.getElementById('inHighestPH').value;
        const maxRadiation = document.getElementById('inHighestPR').value;
        //Aquaculture
        const ph = document.getElementById('inLowestPHL').value;
        const ox = document.getElementById('inLowestOX').value;
        const maxPh = document.getElementById('inHighestPHL').value;
        const maxOx = document.getElementById('inHighestOX').value;

        let minVars = new Array();
        let maximums = new Array();
        let minimums = new Array();

        //If the values are true will be push to the array
        if (typeStation === 'Invernadero') {
            if (minTemperature) {
                minVars.push('temperature');
                minimums.push(temperature);
                maximums.push(maxTemperature);
            }
            if (minHumidity) {
                minVars.push('humidity');
                minimums.push(humidity);
                maximums.push(maxHumidity);
            }
            if (minRadiation) {
                minVars.push('radiation');
                minimums.push(radiation);
                maximums.push(maxRadiation);
            }
        } else {
            if (minTemperature) {
                minVars.push('temperature');
                minimums.push(temperature);
                maximums.push(maxTemperature);
            }
            if (minPh) {
                minVars.push('ph');
                minimums.push(ph);
                maximums.push(maxPh);
            }
            if (minOxigen) {
                minVars.push('oxigen');
                minimums.push(ox);
                maximums.push(maxOx);
            }
        }

        const data = new FormData();
        data.append('id', id);
        data.append('title', name);
        data.append('description', desc);
        data.append('minVars', minVars);
        data.append('minimums', minimums);
        data.append('maximums', maximums);

        if (document.getElementById('inFile').files[0] !== undefined) {
            const photo = document.getElementById('inFile');
            data.append('photo', photo.files[0]);
        }

        station.editStation(data);

    } else if (document.getElementById('titleModal').textContent === "Nueva estación") {
        const photo = document.getElementById('inFile');
        const name = document.getElementById('inName').value;
        const desc = document.getElementById('inDescription').value;

        //Greenhouse
        const temperature = document.getElementById('inLowestPT').value;
        const humidity = document.getElementById('inLowestPH').value;
        const radiation = document.getElementById('inLowestPR').value;
        const maxTemperature = document.getElementById('inHighestPT').value;
        const maxHumidity = document.getElementById('inHighestPH').value;
        const maxRadiation = document.getElementById('inHighestPR').value;
        //Aquaculture
        const ph = document.getElementById('inLowestPHL').value;
        const ox = document.getElementById('inLowestOX').value;
        const maxPh = document.getElementById('inHighestPHL').value;
        const maxOx = document.getElementById('inHighestOX').value;

        let minVars = new Array();
        let maximums = new Array();
        let minimums = new Array();

        //If the values are true will be push to the array
        if (typeStation === 'Invernadero') {
            if (minTemperature) {
                minVars.push('temperature');
                minimums.push(temperature);
                maximums.push(maxTemperature);
            }
            if (minHumidity) {
                minVars.push('humidity');
                minimums.push(humidity);
                maximums.push(maxHumidity);
            }
            if (minRadiation) {
                minVars.push('radiation');
                minimums.push(radiation);
                maximums.push(maxRadiation);
            }
        } else {
            if (minTemperature) {
                minVars.push('temperature');
                minimums.push(temperature);
                maximums.push(maxTemperature);
            }
            if (minPh) {
                minVars.push('ph');
                minimums.push(ph);
                maximums.push(maxPh);
            }
            if (minOxigen) {
                minVars.push('oxigen');
                minimums.push(ox);
                maximums.push(maxOx);
            }
        }

        const data = new FormData();
        data.append('photo', photo.files[0]);
        data.append('title', name);
        data.append('description', desc);
        data.append('minVars', minVars);
        data.append('minimums', minimums);
        data.append('maximums', maximums);

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
                let id;
                let email;

                if (ev.target.classList[0] === 'btn') {

                    id = ev.target.parentNode.parentNode.parentNode.parentNode.
                    parentNode.parentNode.parentNode.parentNode.querySelector('#inId').firstChild.nodeValue;

                    email = ev.target.parentNode.parentNode.parentNode.querySelector('#userEmail').firstChild.nodeValue;
                } else if (ev.target.classList[0] === 'material-icons') {

                    email = ev.target.parentNode.parentNode.parentNode.querySelector('#userEmail').firstChild.nodeValue;

                    id = ev.target.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.querySelector('#inId').firstChild.nodeValue
                }

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

document.getElementById('divTypeButtons').addEventListener('click', (ev) => {
    const divMinBtnsInv = document.getElementById('minValueButtonsInv');
    const divMinBtnsAcu = document.getElementById('minValueButtonsAcu');

    document.getElementById('divInputsLow').style.display = 'none';
    document.getElementById('divInputsHigh').style.display = 'none';

    divMinBtnsInv.style.display = 'none';
    divMinBtnsAcu.style.display = 'none';

    lib.hideInputsBoolean(true);

    const idButton = ev.target.id;
    console.log(idButton)
    if (idButton == 'btnTypeInv') {
        typeStation = 'Invernadero';
    } else {
        typeStation = 'Acuícola';
    }

    document.getElementById('divVar').style.display = 'initial';
});

document.getElementById('btnMinValues').addEventListener('click', () => {
    const divMinBtnsInv = document.getElementById('minValueButtonsInv');
    const divMinBtnsAcu = document.getElementById('minValueButtonsAcu');

    divMinBtnsInv.style.display = 'none';
    divMinBtnsAcu.style.display = 'none';
    document.getElementById('divInputsLow').style.display = 'initial';
    document.getElementById('divInputsHigh').style.display = 'initial';
    console.log(typeStation)
    if (typeStation == 'Invernadero') {
        if (divMinBtnsInv.style.display === 'initial') {
            divMinBtnsInv.style.display = 'none'
        } else {
            divMinBtnsInv.style.display = 'initial'
        }
    } else {
        if (divMinBtnsAcu.style.display === 'initial') {
            divMinBtnsAcu.style.display = 'none'
        } else {
            divMinBtnsAcu.style.display = 'initial'
        }
    }

});

document.getElementById('btnMinRad').addEventListener('click', () => {
    const divRad = document.getElementById('divLowRad');
    const inLowestPR = document.getElementById('inLowestPR');
    const divMaxRad = document.getElementById('divHighRad');
    const inHighestPR = document.getElementById('inHighestPR');

    if (divRad.style.display === 'initial') {
        divRad.style.display = 'none'
        divMaxRad.style.display = 'none'
        inLowestPR.value = "";
        inHighestPR.value = "";
        maxRadiation = false;
        minRadiation = false;
    } else {
        // inLowestPR.value = 17;
        minRadiation = true;
        maxRadiation = true;
        divRad.style.display = 'initial'
        divMaxRad.style.display = 'initial'
    }
});

document.getElementById('btnMinTemp').addEventListener('click', () => {
    const divTemp = document.getElementById('divLowTemp');
    const inLowestPT = document.getElementById('inLowestPT');
    const divMaxTemp = document.getElementById('divHighTemp');
    const inHighestPT = document.getElementById('inHighestPT');

    if (divTemp.style.display === 'initial') {
        divTemp.style.display = 'none'
        divMaxTemp.style.display = 'none'
        inLowestPT.value = "";
        inHighestPT.value = "";
        minTemperature = false;
        maxTemperature = false;
    } else {
        minTemperature = true;
        maxTemperature = true;
        divTemp.style.display = 'initial'
        divMaxTemp.style.display = 'initial'
    }
});

document.getElementById('btnMinHum').addEventListener('click', () => {
    const divHum = document.getElementById('divLowHum');
    const inLowestPH = document.getElementById('inLowestPH');
    const divMaxHum = document.getElementById('divHighHum');
    const inHighestPH = document.getElementById('inHighestPH');

    if (divHum.style.display === 'initial') {
        divHum.style.display = 'none'
        divMaxHum.style.display = 'none'
        inLowestPH.value = "";
        inHighestPH.value = "";
        minHumidity = false;
        maxHumidity = false;
    } else {
        minHumidity = true;
        maxHumidity = true;
        divHum.style.display = 'initial'
        divMaxHum.style.display = 'initial'
    }
});

//Acuicola
document.getElementById('btnMinTempAcu').addEventListener('click', () => {
    const divTemp = document.getElementById('divLowTemp');
    const inLowestPT = document.getElementById('inLowestPT');
    const divMaxTemp = document.getElementById('divHighTemp');
    const inHighestPT = document.getElementById('inHighestPT');

    if (divTemp.style.display === 'initial') {
        divTemp.style.display = 'none'
        divMaxTemp.style.display = 'none'
        inLowestPT.value = "";
        inHighestPT.value = "";
        minTemperature = false;
        maxTemperature = false;
    } else {
        minTemperature = true;
        maxTemperature = true;
        divTemp.style.display = 'initial'
        divMaxTemp.style.display = 'initial'
    }
});

document.getElementById('btnMinPH').addEventListener('click', () => {
    const divPh = document.getElementById('divLowPHL');
    const inLowestPHL = document.getElementById('inLowestPHL');
    const divMaxPh = document.getElementById('divHighPHL');
    const inHighestPHL = document.getElementById('inHighestPHL');

    if (divPh.style.display === 'initial') {
        divPh.style.display = 'none';
        divMaxPh.style.display = 'none';
        inLowestPHL.value = "";
        inHighestPHL.value = "";
        minPh = false;
        maxPh = false;
    } else {
        minPh = true;
        maxPh = true;
        divPh.style.display = 'initial';
        divMaxPh.style.display = 'initial';
    }
});

document.getElementById('btnMinOx').addEventListener('click', () => {
    const divOx = document.getElementById('divLowOx');
    const inLowestOx = document.getElementById('inLowestOX');
    const divMaxOx = document.getElementById('divHighOx');
    const inHighestOx = document.getElementById('inHighestOX');

    if (divOx.style.display === 'initial') {
        divOx.style.display = 'none';
        divMaxOx.style.display = 'none';
        inLowestOx.value = "";
        inHighestOx.value = "";
        minOxigen = false;
        maxOxigen = false;
    } else {
        minOxigen = true;
        maxOxigen = true;
        divOx.style.display = 'initial'
        divMaxOx.style.display = 'initial'
    }
});
