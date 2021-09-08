<template>
    <div class="content-wrapper" data-app>
        <div class="row">
            <div class="col-md-12 mx-auto">
                
                <div class="row ">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Casting Stations</h4>
                                
                                <div class="view_main">
                                    <div class="view_wrap grid-view">
                                        <div class="view_item" v-for="cs in casting_stations" :key="cs.casting_station_id">
                                            <div class="vi_right">
                                                <p class="title"> {{ cs.casting_station_id }} </p>
                                                <p> Orders Progress: </p>

                                                <!-- <div :id="cs.casting_station_id"> </div> -->

                                                <div class="progress progress-lg mt-2">
                                                    <div class="progress-bar bg-success progress-bar-striped2 progress-bar-animated" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" :id="cs.casting_station_id">60%</div>
                                                </div>
                                                
                                                <!-- <inertia-link class="nav-link" :href="route('dashboard')" @click="addActiveClass('dashboard')">
                                                    
                                                </inertia-link> -->

                                                <inertia-link class="btn btn-primary btn-rounded btn-fw" style="margin-top: 20px!important;" :href="route('orders-monitor-view-station',  cs.casting_station_id )">
                                                    Monitor Now
                                                </inertia-link>
                                            </div>
                                        </div>
                                    </div>
                                </div>      
    
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
        
        
    },
    data: () => ({
        
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
    }
};
</script>
