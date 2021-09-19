<template>
   <!-- <div class="content-wrapper" data-app> -->
        <div class="row" data-app>
            <div class="col-md-12 mx-auto">
                <div class="row ">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Today's Former Data</h4>
                                    <div class="row" style="margin: 8px; padding-left: 15px; align-items: center">
                                        <span style="color: white; padding-right: 15px">Select Customer: </span>
                                        <v-select-graph label="customer_id" @input="onSelectCust" :options="this.customers" :clearable="false"></v-select-graph>
                                        <span style="color: white; padding-left: 15px; padding-right: 15px">Select Mould Type: </span>
                                        <v-select-graph label="mould_id" @input="onSelectMould" :disabled="disabled" :options="this.cust_select" :clearable="false"></v-select-graph>
                                    </div>
                                <div style="height: 60vh;" id="chartdiv"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- </div> -->
</template>

<style>
.style-chooser .vs__search::placeholder,
.style-chooser .vs__dropdown-toggle,
.style-chooser .vs__dropdown-menu {
  background: #dfe5fb;
  border: none;
  color: #394066;
  text-transform: lowercase;
  font-variant: small-caps;
  width: 300px;
}

.style-chooser .vs__clear,
.style-chooser .vs__open-indicator {
  fill: #394066;
}

/*
Padding-left 0 because vuetify css adds 24px of padding to ul tags which include the dropdown menu
*/
.vs__dropdown-menu {
  background:#1B2634;
  width: 300px;
  padding-left: 0px !important;
}

/* List Items */
.vs__dropdown-option {
  color: rgb(250, 250, 250);
}

.vs__actions {
  color: rgb(250, 250, 250);
}

.vs__selected {
  color: rgb(250, 250, 250);
}

</style>

<script>
import Layout from "@/Shared/Layout";
import * as am4core from "@amcharts/amcharts4/core";
import * as am4charts from "@amcharts/amcharts4/charts";
import am4themes_dark from "@amcharts/amcharts4/themes/dark";
import am4themes_animated from "@amcharts/amcharts4/themes/animated";

export default {
    //metaInfo: { title: "Orders Monitor" },
    layout: Layout,
    components: {},
    props: ["casting_stations", "plaster_moulds", "customers", "orders"],
    mounted() {

        // dynamic variable name
        // this[this.casting_stations[i].casting_station_id] = "test " + this.casting_stations[i].casting_station_id;
        // $("#LIPPERT1").css("width", "20%");
        // $("#LIPPERT1").text("20%");

        am4core.useTheme(am4themes_dark);
        am4core.useTheme(am4themes_animated);
        // Themes end

        this.chart = am4core.create("chartdiv", am4charts.XYChart);
        this.chart.colors.step = 2;
        
        // Create axes
        var dateAxis = this.chart.xAxes.push(new am4charts.DateAxis());
        dateAxis.renderer.minGridDistance = 50;
        dateAxis.baseInterval = {
        "timeUnit": "minute",
        "count": 1
        };
        var valueAxis = this.chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.title.text = "Weight (kg)";
        
        // Create series object if multiple series are required
        // for(var item in this.devices) {                
        //     this['series' + item] = this.chart.series.push(new am4charts.LineSeries());
        //     this['series' + item].name = this.devices[item].device;
        //     this['series' + item].dataFields.valueY = this.devices[item].device;
        //     this['series' + item].dataFields.dateX = "date";
        //     this['series' + item].strokeWidth = 2;
        //     this['series' + item].minBulletDistance = 10;
        //     this['series' + item].tooltipText = "[bold]" + this.devices[item].device +": {" + this.devices[item].device + "} kg\n";
        //     this['series' + item].tooltip.pointerOrientation = "vertical";
        //     this['circleBullet' + item] = this['series' + item].bullets.push(new am4charts.CircleBullet());
        // }

        //Create series object 
        this['series'] = this.chart.series.push(new am4charts.LineSeries());
        this['series'].name = "No Series Available";
        this['series'].dataFields.valueY = "weight"; //Change this to device's name if you want multipled series in a chart
        this['series'].dataFields.dateX = "date";
        this['series'].strokeWidth = 2;
        this['series'].minBulletDistance = 10;
        this['series'].tooltipText = "{" + "weight" + "} kg\n";
        this['series'].tooltip.pointerOrientation = "vertical";
        this['circleBullet'] = this['series'].bullets.push(new am4charts.CircleBullet());
        
        // Add cursor
        this.chart.cursor = new am4charts.XYCursor();
        // this.chart.cursor.xAxis = dateAxis;

        // Add legend
        this.chart.legend = new am4charts.Legend();
        this.chart.legend.maxWidth = undefined;

        // Create value axis range
     
        //Max Range
        this.range = valueAxis.axisRanges.create();
        this.range.value = 0;
        this.range.grid.stroke = am4core.color("#A96478");
        this.range.grid.strokeWidth = 2;
        this.range.grid.strokeOpacity = 1;
        this.range.label.inside = true;
        this.range.label.text = "";
        this.range.label.fill = this.range.grid.stroke;
        this.range.label.align = "right";
        this.range.label.verticalCenter = "top";

        //Average Range
        this.range3 = valueAxis.axisRanges.create();
        this.range3.value = 0;
        this.range3.grid.stroke = am4core.color("#ffd801");
        this.range3.grid.strokeWidth = 2;
        this.range3.grid.strokeOpacity = 0.8;
        this.range3.label.inside = true;
        this.range3.label.text = "";
        this.range3.label.fill = this.range3.grid.stroke;
        this.range3.label.align = "center";
        this.range3.label.verticalCenter = "top";

        //Min Range
        this.range2 = valueAxis.axisRanges.create();
        this.range2.value = 0;
        this.range2.grid.stroke = am4core.color("#396478");
        this.range2.grid.strokeWidth = 2;
        this.range2.grid.strokeOpacity = 1;
        this.range2.label.inside = true;
        this.range2.label.text = "";
        this.range2.label.fill = this.range2.grid.stroke;
        this.range2.label.align = "left";
        this.range2.label.verticalCenter = "top";

        // Zoom
        this.chart.cursor = new am4charts.XYCursor();
        this.chart.cursor.lineY.opacity = 0;
        //chart.cursor.behavior = "none";
        this.chart.scrollbarX = new am4charts.XYChartScrollbar();
        //dateAxis.start = 0.8;
        //dateAxis.keepSelection = true;
        
        // title container
        var topContainer = this.chart.chartContainer.createChild(am4core.Container);
        topContainer.layout = "absolute";
        topContainer.toBack();
        topContainer.paddingBottom = 15;
        topContainer.width = am4core.percent(100);

        // title
        this.axisTitle = topContainer.createChild(am4core.Label);
        // this.axisTitle.text = moment(new Date()).format("DD MMMM YYYY") + " - Fridge Live Temperature (℃)";
        this.axisTitle.text = "Mould Type: N/A";
        this.axisTitle.fontWeight = 600;
        this.axisTitle.align = "left";
        this.axisTitle.paddingLeft = 10;
        
        this.label = this.chart.createChild(am4core.Label);
        this.label.text = "No data available";
        this.label.fontSize = 20;
        this.label.isMeasured = false;
        this.label.x = am4core.percent(50);
        this.label.y = am4core.percent(50);
        this.label.horizontalCenter = "middle";  
  
        // Enable export
        this.chart.exporting.menu = new am4core.ExportMenu();
        this.chart.exporting.menu.items = [{
            "label": "...",
            "menu": [
                { "type": "png", "label": "PNG" },
                { "type": "csv", "label": "CSV" },
                { "type": "print", "label": "Print" }
            ]
        }];    
        
        this.chart.preloader.disabled = false;
    },
    data: () => ({
        chart: "",
        range: "",
        range2: "",
        range3: "",
        axisTitle: "",
        label: "",
        cust_select: [],
        disabled: true,
		polling: null
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
        onSelectCust(value) {
            this.disabled = false;
            this.cust_select = this.orders[value.customer_tbl_id];
            console.log(this.cust_select);
        },
        onSelectMould(value) {
            clearInterval(this.polling)
            this.axios.get(this.route('former-data', value.order_tbl_id)).then((response) => {
                this.changeData(response.data);
            }).catch(function (error) {
                console.log(error);
            })
            this.pollData(value)
        },
        changeData(data){
            var array = [];
            var avg_weight = 0;
            data.former_data.forEach(function (item){
                var obj = {};
                obj.date = new Date(item.created_at), 
                obj.weight = item.former_weight; //Change weight to device's name if you want multipled series in a chart
                avg_weight = avg_weight + item.former_weight;
                array.push(obj);
            })

            if (data.former_data.length === 0){
                this.label.text = "..."
                setTimeout(() => {this.label.text = "No data available"}, 1000);
                //this.label.text = "No data available";
                this.range.value = 0;
                this.range.label.text = "";
                this.range2.value = 0;
                this.range2.label.text = "";
                this.range3.value = 0;
                this.range3.label.text = "";
            }
            else{
                avg_weight = (avg_weight/(data.former_data.length)).toFixed(2);
                this.label.text = "";
                this.range.value = data.order.fmr_opt_wgt_max;
                this.range2.value = data.order.fmr_opt_wgt_min;
                this.range3.value = avg_weight;
                this.range.label.text = "Maximum Optimum Weight (" + data.order.fmr_opt_wgt_max + "kg)";
                this.range2.label.text = "Minimum Optimum Weight (" + data.order.fmr_opt_wgt_min + "kg)";
                this.range3.label.text = "Average Weight (" + avg_weight + "kg)";
            }
            if (JSON.stringify(this.chart.data) !== JSON.stringify(array)){
                this.chart.data = array;
                this.series.name = data.order.mould_model.mould_mdl_id;
                this.axisTitle.text = "Mould Type: " + data.order.mould_model.mould_mdl_id;
            }
        },
        pollData (value) {
            this.polling = setInterval(() => {
                this.axios.get(this.route('former-data', value.order_tbl_id)).then((response) => {
                    this.changeData(response.data);
                }).catch(function (error) {
                    console.log(error);
                })
            }, 15000)
        }
        
    },
    beforeDestroy () {
        //Prevent memory leaks
        this.chart.dispose();
	    clearInterval(this.polling)
    }
};
</script>
