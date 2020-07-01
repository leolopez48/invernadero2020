$('document').ready(function () {
    map();
    loadGraphics();
});

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

    // // Configure series tooltip
    var polygonTemplate = polygonSeries.mapPolygons.template;
    polygonTemplate.tooltipText = "{name} {value}";
    polygonTemplate.nonScalingStroke = true;
    polygonTemplate.strokeWidth = 0.5;

    // // Create hover state and set alternative fill color
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

function loadGraphics() {
    am4core.disposeAllCharts(); //Advertencia 'Chart was not disposed'
    map();
    graphics('graphicLineDiv');
    graphics('graphicLineHumDiv');
    graphics('graphicLineRadDiv');
}

$('#idSantaAna1').on('click', (ev) => {

    ev.preventDefault();
    $('#tituloEst').text("Santa Ana");
    $("#descEst").text("Santa Ana");
    map();
    emptyDiv();
    loadGraphics();
    message('Santa Ana');
    $('#idSelect').trigger('click');
});

function emptyDiv() {
    $('#graphicLineDiv').empty();
    $('#graphicLineHumDiv').empty();
    $('#graphicLineRadDiv').empty();
}

function graphics(graphicName) {
    am4core.ready(function () {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create(graphicName, am4charts.XYChart);
        chart.language.locale = am4lang_es_ES;
        // Add data
        chart.data = generateChartData();

        // Create axes
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        dateAxis.renderer.minGridDistance = 50;

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

        // Create series
        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.valueY = "visits";
        series.dataFields.dateX = "date";
        series.strokeWidth = 2;
        series.minBulletDistance = 10;
        series.tooltipText = "{valueY}";
        series.tooltip.pointerOrientation = "vertical";
        series.tooltip.background.cornerRadius = 20;
        series.tooltip.background.fillOpacity = 0.5;
        series.tooltip.label.padding(12, 12, 12, 12)

        // Add scrollbar
        chart.scrollbarX = new am4charts.XYChartScrollbar();
        chart.scrollbarX.series.push(series);

        // Add cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.xAxis = dateAxis;
        chart.cursor.snapToSeries = series;

        function generateChartData() {
            var chartData = [];
            var firstDate = new Date('Jan 1, 2020 00:00:00');
            firstDate.setDate(firstDate.getDate());
            var visits = 1200;
            for (var i = 0; i < 60; i++) {
                // we create date objects here. In your data, you can have date strings
                // and then set format of your dates using chart.dataDateFormat property,
                // however when possible, use date objects, as this will speed up chart rendering.
                var newDate = new Date(firstDate);

                newDate.setDate(newDate.getDate() + i);
                //console.log(newDate);
                let random = Math.random() * (35 - 25) + 25;
                //console.log(random);
                visits = Math.round(random);

                chartData.push({
                    date: newDate,
                    visits: visits
                });
            }
            return chartData;
        }

    }); // end am4core.ready()
}
