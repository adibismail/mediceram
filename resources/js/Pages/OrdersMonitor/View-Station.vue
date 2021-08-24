<template>
    <div class="content-wrapper" data-app>
        <div class="row">
            <div class="col-md-12 mx-auto">
                
                <div class="row ">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Monitor Orders of Station </h4>
                                


                                <div style="height: 500px;" id="chartdiv"></div>
                                


                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
import Layout from "@/Shared/Layout";
import * as am4core from "@amcharts/amcharts4/core";
import * as am4charts from "@amcharts/amcharts4/charts";
import am4themes_dark from "@amcharts/amcharts4/themes/dark";
import am4themes_animated from "@amcharts/amcharts4/themes/animated";

export default {
    metaInfo: { title: "Orders Monitor" },
    layout: Layout,
    components: { 
        
     },
    props: ["casting_stations"],
    mounted() {

        // dynamic variable name
        // this[this.casting_stations[i].casting_station_id] = "test " + this.casting_stations[i].casting_station_id;
        // $("#LIPPERT1").css("width", "20%");
        // $("#LIPPERT1").text("20%");

        am4core.useTheme(am4themes_dark);
        am4core.useTheme(am4themes_animated);
        // Themes end


        var chart = am4core.create("chartdiv", am4charts.XYChart);
        chart.colors.step = 2;
        
        for(var item in this.liveData) {
            var datetime = this.liveData[item].date + " " + this.liveData[item].time;
            chart.data.push({
                date: new Date(datetime), 
                [this.liveData[item].device]: this.liveData[item]['temp']
            });
        }

        // Create axes
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        dateAxis.renderer.minGridDistance = 50;

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.title.text = "Weight (kg)";
        
        // Create series
        for(var item in this.devices) {                
            this['series' + item] = chart.series.push(new am4charts.LineSeries());
            this['series' + item].name = this.devices[item].device;
            this['series' + item].dataFields.valueY = this.devices[item].device;
            this['series' + item].dataFields.dateX = "date";
            this['series' + item].strokeWidth = 2;
            this['series' + item].minBulletDistance = 10;
            
            this['series' + item].tooltipText = "[bold]" + this.devices[item].device +": {" + this.devices[item].device + "} ℃\n";
            this['series' + item].tooltip.pointerOrientation = "vertical";
            
            this['circleBullet' + item] = this['series' + item].bullets.push(new am4charts.CircleBullet());
        }

        // Add cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.xAxis = dateAxis;

        // Add legend
        chart.legend = new am4charts.Legend();
        chart.legend.maxWidth = undefined;

        // Create value axis range
        // var range3 = valueAxis.axisRanges.create();
        // range3.value = -25.397;
        // range3.endValue = -25.698;
        // range3.axisFill.fill = am4core.color("#f3ca63");
        // range3.axisFill.fillOpacity = 0.3;
        // range3.grid.strokeOpacity = 0;

        let range = valueAxis.axisRanges.create();
        range.value = 1.55;
        range.grid.stroke = am4core.color("#A96478");
        range.grid.strokeWidth = 2;
        range.grid.strokeOpacity = 1;
        range.label.inside = true;
        range.label.text = "Maximum Optimum Weight (1.55kg)";
        range.label.fill = range.grid.stroke;
        range.label.align = "right";
        range.label.verticalCenter = "bottom";

        let range2 = valueAxis.axisRanges.create();
        range2.value = 1.2;
        range2.grid.stroke = am4core.color("#396478");
        range2.grid.strokeWidth = 2;
        range2.grid.strokeOpacity = 1;
        range2.label.inside = true;
        range2.label.text = "Minimum Optimum Weight (1.00kg)";
        range2.label.fill = range2.grid.stroke;
        range2.label.align = "right";
        range2.label.verticalCenter = "bottom";
        
        // Zoom
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.lineY.opacity = 0;
        //chart.cursor.behavior = "none";
        chart.scrollbarX = new am4charts.XYChartScrollbar();
        //dateAxis.start = 0.8;
        //dateAxis.keepSelection = true;
        
        // title container
        var topContainer = chart.chartContainer.createChild(am4core.Container);
        topContainer.layout = "absolute";
        topContainer.toBack();
        topContainer.paddingBottom = 15;
        topContainer.width = am4core.percent(100);

        // title
        var axisTitle = topContainer.createChild(am4core.Label);
        // axisTitle.text = moment(new Date()).format("DD MMMM YYYY") + " - Fridge Live Temperature (℃)";
        axisTitle.text = "Mould Type: E3423";
        axisTitle.fontWeight = 600;
        axisTitle.align = "left";
        axisTitle.paddingLeft = 10;
        
        // Enable export
        chart.exporting.menu = new am4core.ExportMenu();
        chart.exporting.menu.items = [{
            "label": "Export Chart",
            "menu": [
                { "type": "png", "label": "PNG" },
                { "type": "csv", "label": "CSV" },
                { "type": "print", "label": "Print" }
            ]
        }];


        
        
    },
    data: () => ({
        liveData: [
            {id: 5, device: "E3423", date: "2021-05-21", time: "12:51:36", temp: "1.50"},
            {id: 5, device: "E3423", date: "2021-05-21", time: "12:52:38", temp: "1.30"},
            {id: 5, device: "E3423", date: "2021-05-21", time: "12:53:38", temp: "1.70"},
            {id: 5, device: "E3423", date: "2021-05-21", time: "12:54:38", temp: "1.40"},
            {id: 5, device: "E3423", date: "2021-05-21", time: "12:55:38", temp: "1.50"},
            {id: 5, device: "E3423", date: "2021-05-21", time: "12:56:39", temp: "1.35s"},
            {id: 5, device: "E3423", date: "2021-05-21", time: "12:57:39", temp: "1.50"}
        ],
        devices: [
            {device: "E3423"},
        ]
    }),
    computed: {
        
    },
    watch: {

    },
    created() {
        // this.initialize();
    },
    methods: {
        // methods
        test() {
            console.log("test")
        }
    }
};
</script>
