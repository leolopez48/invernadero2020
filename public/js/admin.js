const url = 'http://localhost:8000/api/';

//Listeners
document.getElementById('btnNew').addEventListener('click', (ev) => {
    ev.preventDefault();
    document.getElementById('titleModal').textContent = 'Nueva estación';
    // resetForm();
    closeLoader();
});

document.getElementById('station').addEventListener('click', (ev) => {
    ev.preventDefault();
    loadStationModal(ev);
    document.getElementById('titleModal').textContent = 'Editar estación';

});

document.addEventListener('DOMContentLoaded', (ev) => {
    loadData();
    openLoader();
    setTimeout(() => {
        closeLoader();
    }, 500);
});
// END LISTENERS

//FUNCTIONS
function loadData() {
    for (let i = 0; i < 5; i++) {
        const stations = document.getElementById('divStations');
        const station = document.createElement('div');
        station.innerHTML = `
        <a class="station modal-trigger animate__animated animate__fadeIn" id="station" href="#modal1">
            <div class="col s12 m3 l2 m-1 white rounded hoverable">
                <div class=" col s12 center">
                    <img class="circle center-align p-1" src="https://picsum.photos/id/110/110/110" alt="">
                </div>
                <div class="col s12 center">
                    <strong class="center black-text">Titulo</strong>
                    <p class="black-text p-1 left-align">Lorem ipsum dolor sit, amet consectetur adipisicing
                        elit.
                        Impedit, molestiae?
                    </p>
                </div>
            </div>
        </a>
        `;
        stations.appendChild(station);

    }
}

function loadStationModal(ev) {
    console.log(ev.target.parentNode)
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
// END LOADER
