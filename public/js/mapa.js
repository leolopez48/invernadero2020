var LowestLimit = 15;
const DefaultValue = 0;
const url = 'http://localhost:8000/api/';

$('document').ready(function () {
    const enabled = {
        state: true
    }
    getStations(enabled);
    document.getElementById('divData').style.display = 'none';
    document.getElementById('divTable').style.display = 'none';
    document.getElementById('titleGraphics').textContent = '';
    //Init modal filter
    var modal = document.querySelectorAll('.modal');
    var instances = M.Modal.init(modal);
});

document.getElementById('btnModalFilter').addEventListener('click', (ev) => {

    ev.preventDefault();

    const id = document.getElementById('IdEst').firstChild.textContent;
    const fStart = document.getElementById('filterStart').value;
    const fEnd = document.getElementById('filterEnd').value;

    const data = {
        'id': id,
        'start': fStart,
        'end': fEnd
    }

    filterRecords(data);
});

document.getElementById('stations').addEventListener('click', (ev) => {
    ev.preventDefault();

    if (ev.target.classList[0] === 'card-panel') {
        const stId = ev.target.querySelector('#stId').textContent;
        const stPhoto = ev.target.querySelector('#stPhoto').src;
        const stTitle = ev.target.querySelector('#stTitle').firstChild.nodeValue;
        const stDescription = ev.target.querySelector('#stDescription').firstChild.nodeValue;

        document.getElementById('tituloEst').textContent = stTitle;
        document.getElementById('descEst').textContent = stDescription;
        document.getElementById('stBackground').src = stPhoto;
        document.getElementById('IdEst').textContent = stId;

        getData(stId);
        message(stTitle);
    }
});

document.getElementById('btnDelFilter').addEventListener('click', (ev)=>{
    ev.preventDefault();
    const id = document.getElementById('IdEst').firstChild.textContent;
    getData(id);
    document.getElementById('btnDelFilter').style.visibility = 'hidden';
});

function filterRecords(data) {
    fetch(url+'filter', {
        method: 'POST',
        mode: "cors",
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        return response.json();
    }).then(function (data) {
        if (data.message == 'success') {
            if(data.records.length > 0){
                loadTable(data.records);
                loadGraphics(data);
                showMessage('Datos actualizados','', 'success');
                document.getElementById('btnDelFilter').style.visibility = 'visible';
            }else{
                showMessage('No se encontraron datos.','','warning');
            }
            filterReset();
        } else {
            showMessage('Datos incorrectos, inténtalo de nuevo!', 'danger');
        }
    });
}

function showMessage(title, description, icon){
    Swal.fire(
        title,
        description,
        icon
      );
}

function getData(id) {
    fetch(url + `get/${id}`, {
            method: 'GET',
            mode: 'cors',
            cache: 'default'
        })
        .then((response) => response.json())
        .then((data) => {
            loadTable(data.records);
            loadGraphics(data);
        });
}

function getStations(body) {
    fetch(url + 'stations/get', {
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
            loadStations(data.stations);
        });
}

function filterReset(){
    document.getElementById('filterStart').value = 'Y-m-d';
    document.getElementById('filterEnd').value = 'Y-m-d';
}

function selectStation(station) {
    document.getElementById('tituloEst').textContent = station[0].title;
    document.getElementById('descEst').textContent = station[0].description;
    document.getElementById('stBackground').src = station[0].photo;
    document.getElementById('IdSelected').textContent = station[0].id;
}

function loadStations(stations) {
    const divStations = document.getElementById('stations');
    for (let i = 0; i < stations.length; i++) {
        const station = document.createElement('div');
        station.innerHTML = `
        <div class="col s12 m6" id="est">
            <div class="card" style="height:120px;">
                <div class="card-panel grey lighten-5 z-depth-2">
                        <div class="row valign-wrapper">
                            <p id="stId" style="display: none;">${stations[i].id}</p>
                            <div class="col s3">
                                <img class="circle center-align" src="${stations[i].photo}" id="stPhoto" width="60px" height="60px">
                            </div>
                            <div class="col s10">
                                <h6 id="stTitle" class="blue-text">${stations[i].title}</h6>
                                <span id="stDescription" class="black-text">
                                    ${stations[i].description}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `;
        divStations.appendChild(station);
    }
}

function loadTable(records) {
    $('#idTabla').empty();

    for (let i = 0; i < records.length; i++) {
        let temperatura = records[i].temperature;
        let humedad = records[i].humidity;
        let radiacion = records[i].radiation;
        let created_at = records[i].created_at;

        $('#idTabla').append(
            '<tr>' +
            '<td>' + (i + 1) + '</td>' +
            '<td>' + created_at + '</td>' +
            '<td>' + temperatura + '</td>' +
            '<td>' + humedad + '</td>' +
            '<td>' + radiacion + '</td>' +
            '</tr>'
        );
    }
}

function mapSelected(dep, id) {
    $('#depSelected').text(dep);
    $('#idSelected').text('Código: ' + id);
    $('#btnModal').trigger('click');
}

function map() {
    // Theme
    am4core.useTheme(am4themes_animated);

    // Create map instance
    let chart = am4core.create("chartdiv", am4maps.MapChart);

    chart.language.locale = am4lang_es_ES;
    // chart.numberFormatter.language = new am4core.Language();
    // chart.numberFormatter.language.locale = am4lang_es_ES;
    // chart.dateFormatter.language = new am4core.Language();
    // chart.dateFormatter.language.locale = am4lang_es_ES;
    // Set map definition
    chart.geodata = am4geodata_elSalvadorLow;

    // Set projection
    // chart.projection = new am4maps.projections.AlbersUsa();

    // Create map polygon series
    var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());

    // Set min/max fill color for each area
    polygonSeries.heatRules.push({
        property: "fill",
        target: polygonSeries.mapPolygons.template,
        min: chart.colors.getIndex(1).brighten(1),
        max: chart.colors.getIndex(1).brighten(-0.3),
        logarithmic: true
    });

    // Make map load polygon data (state shapes and names) from GeoJSON
    polygonSeries.useGeodata = true;

    var polygonTemplate = polygonSeries.mapPolygons.template;

    var home = chart.chartContainer.createChild(am4core.Button);
    home.label.text = "Inicio";
    home.id = 'btnInicio';
    home.align = "right";
    home.events.on("hit", function (ev) {
        chart.goHome();
        $('#tituloEst').text("Estación ENA");
        $("#descEst").text("Invernadero ubicado en ENA");
        message('ENA');
        //$('#btnInicio').trigger('click');
        //console.log("Mapa nacional");
    });

    //Create Zoom Control
    chart.zoomControl = new am4maps.ZoomControl();

    var polygonTemplate = polygonSeries.mapPolygons.template;
    polygonTemplate.events.on("hit", function (ev) {
        // zoom to an object
        //ev.target.series.chart.zoomToMapObject(ev.target);

        // get object info
        let dep = ev.target.dataItem.dataContext.name;
        let id = ev.target.dataItem.dataContext.id;
        //console.log(ev.target.dataItem.dataContext.name + ": " + ev.target.dataItem.dataContext.id);
        mapSelected(dep, id);
        //alert(ev.target.dataItem.dataContext.name);
        //alert(ev.target.dataItem.dataContext.name);
    });

    // Configure series tooltip
    var polygonTemplate = polygonSeries.mapPolygons.template;
    polygonTemplate.tooltipText = "{name} {value}";
    polygonTemplate.nonScalingStroke = true;
    polygonTemplate.strokeWidth = 0.5;

    // Create hover state and set alternative fill color
    var hs = polygonTemplate.states.create("hover");
    hs.properties.fill = am4core.color("#3c5bdc");
}

function message(estacion) {
    Swal.fire(
        'Estación seleccionada: ' + estacion,
        'Estación ubicada en ' + estacion,
        'success'
    )
}

function loadGraphics(data) {
    if (data.records.length != 0) {
        showDivData();
        am4core.disposeAllCharts(); //Advertencia 'Chart was not disposed'
        graphics('graphicLineDiv', data, 1);
        graphics('graphicLineHumDiv', data, 2);
        graphics('graphicLineRadDiv', data, 3);
    } else {
        hideDivData();
    }
}

function emptyDiv() {
    $('#graphicLineDiv').empty();
    $('#graphicLineHumDiv').empty();
    $('#graphicLineRadDiv').empty();
}

function graphics(graphicName, data, type) {

    am4core.ready(function () {
        // Themes begin
        am4core.useTheme(am4themes_material);
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create(graphicName, am4charts.XYChart);
        // Set input format for the dates
        chart.dateFormatter.dateFormat = "dd-MM-yyyy HH:mm:ss";

        // Add data
        var value, date;
        for (var i = 0; i < data.records.length; i++) {
            switch (type) {
                case 1:
                    value = data.records[i].temperature;
                    LowestLimit = data.temperatureL;
                    break;
                case 2:
                    value = data.records[i].humidity;
                    LowestLimit = data.humidityL;
                    break;
                case 3:
                    value = data.records[i].radiation;
                    LowestLimit = data.radiationL;
                    break;
            }
            date = new Date(data.records[i].created_at);

            chart.data.push({
                date: date,
                value1: value,
                value2: LowestLimit,
                date2: date
            });
        }

        // Create axes
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        dateAxis.renderer.minGridDistance = 50;

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

        // Create series
        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.valueY = "value1";
        series.dataFields.dateX = "date";
        series.strokeWidth = 2;
        series.minBulletDistance = 10;
        series.tooltipText = "[bold]{date.formatDate()}:[/] {value1}\n[bold]{previousDate.formatDate()}:[/] {value2}";
        series.tooltip.pointerOrientation = "vertical";
        series.stroke = am4core.color("blue").lighten(0.5);

        // Create series
        var series2 = chart.series.push(new am4charts.LineSeries());
        series2.dataFields.valueY = "value2";
        series2.dataFields.dateX = "date";
        series2.strokeWidth = 2;
        series2.strokeDasharray = "3,4";
        series2.stroke = am4core.color("red");
        // Add cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.xAxis = dateAxis;

    }); // end am4core.ready()
}

function hideDivData() {
    document.getElementById('divData').style.display = 'none';
    document.getElementById('divTable').style.display = 'none';
    document.getElementById('titleGraphics').textContent = 'Estación sin registros';
}

function showDivData() {
    document.getElementById('divData').style.display = 'initial';
    document.getElementById('divTable').style.display = 'initial';
    document.getElementById('titleGraphics').textContent = 'Datos registrados';
}
