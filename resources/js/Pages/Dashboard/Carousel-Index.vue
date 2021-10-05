<template>
<v-app>
    <div class="content-wrapper" style="padding: 1rem 0rem !important;" data-app>
        <v-slide-group
        multiple
        show-arrows
        dark>
        <v-slide-item dark>
            <div class="column group-1">
                <div class="row">
                    <div class="col-xl-4 col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 style="color: white">Daily Formers Passed</h5>
                                <div class="row">
                                    <div class="col-9">
                                        <div class="d-flex align-items-center align-self-start">
                                            <h2 class="mb-0" style="color: white"> {{daily_total_passed}} </h2>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="icon icon-box-success ">
                                            <span
                                                class="mdi mdi-arrow-top-right icon-item"
                                            ></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 style="color: white">Daily Formers Failed</h5>
                                <div class="row">
                                    <div class="col-9">
                                        <div
                                            class="d-flex align-items-center align-self-start"
                                        >
                                            <h2 class="mb-0" style="color: white"> {{daily_total_failed}} </h2>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="icon icon-box-danger">
                                            <span
                                                class="mdi mdi-arrow-bottom-left icon-item"
                                            ></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 style="color: white">Total Moulds</h5>
                                <div class="row">
                                    <div class="col-9">
                                        <div
                                            class="d-flex align-items-center align-self-start"
                                        >
                                            <h2 class="mb-0" style="color: white"> {{total_moulds}} </h2>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="icon icon-box-success">
                                            <span
                                                class="mdi mdi-arrow-top-right icon-item"
                                            ></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-4 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row justify-content-between">
                                    <h4 class="card-title">Recent Former Failures</h4>
                                </div>
                                <div class="preview-list">
                                    <div class="preview-item border-bottom">
                                        <div class="preview-item-content d-flex flex-grow">
                                        
                                            <div class="flex-grow">
                                                <v-virtual-scroll
                                                :bench="benched"
                                                :items="recent_fails"
                                                height="250"
                                                item-height="80"
                                                >
                                                <template v-if="recent_fails != 'Empty'" v-slot:default="{ item }">
                                                    <v-list-item :key="item.former_tbl_id" dark>
                                                    <v-list-item-content>
                                                        <v-list-item-title>
                                                            EPC: <strong>{{ item.epc.epc}}</strong>
                                                        </v-list-item-title>
                                                        <v-list-item-subtitle>
                                                            Creation Time: <strong>{{ item.created_at}}</strong>
                                                        </v-list-item-subtitle>
                                                        <v-list-item-subtitle>
                                                            Failure Code: <strong>{{ item.qc.qc_name}}</strong>
                                                        </v-list-item-subtitle>
                                                    <hr style="border-top: 1px solid #E0E1E4 !important; margin-top: 6px !important; padding-bottom: 10px;">
                                                    </v-list-item-content>
                                                    </v-list-item>
                                            
                                                </template>

                                                <div v-else>
                                                    <span style="color: white">No failed formers in the past 7 days</span>
                                                </div>

                                                </v-virtual-scroll>
                                                
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-8 grid-margin stretch-card">
                        
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">All Moulds</h4>
                                <v-data-table dark 
                                height="45vh"
                                :headers="headers" 
                                :items="plaster_moulds" 
                                sort-by="created_at" 
                                class="elevation-1 table-bg">
                                    <template v-slot:top>
                                           <v-spacer></v-spacer>

                                            <!-- <template v-slot:activator="{ on, attrs }">
                                                <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
                                                    Export Data
                                                </v-btn>
                                            </template> -->
                                    </template>
                                </v-data-table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </v-slide-item>
        <v-slide-item>
            <div class="group-2 mx-9" >
            <graph :orders="orders" :customers="customers"></graph>
            </div>
        </v-slide-item>
        <v-slide-item>
            <div class="group-3 mx-9">
            <rejection-table :moulds="moulds"></rejection-table>
             </div>
        </v-slide-item>
        </v-slide-group>
    </div>
    <!-- content-wrapper ends -->
</v-app>
</template>

<style scoped>

 /* For PC with minimum resolution till yPC resolution */ 
@media only screen and (min-width: 769px) and (max-width: 1400px) {
    .group-1 {width: 83vw;}
    .group-2 {width: 80vw;}
    .group-3 {width: 80vw;}

}
/* For Screen Higher than 1400px */ 
@media only screen and (min-width: 1401px) {
     .group-1 {width: 88vw;}
     .group-2 {width: 88vw;}
     .group-3 {width: 86vw;}
} 

</style>

<script>
import Layout from "@/Shared/Layout";
import graph from '../OrdersMonitor/View-Station.vue';
import RejectionTable from '../OrdersMonitor/rejection-table.vue';

export default {
    metaInfo: { title: "Dashboard" },
    layout: Layout,
    props: ["daily_total_passed", "daily_total_failed", "total_moulds",
            "recent_fails", "plaster_moulds", "orders", "customers", "moulds"],
    components: {
        graph,
        RejectionTable,
    },
    data: () => ({
        benched: 0,
        dialog: false,
        dialogDelete: false,
        headers: [
            { text: "EPC", value: "epc" },
            { text: "Mould Model", value: "mould_mdl_id" },
            { text: "Plaster Moulding Station", value: "plaster_moulding_station_id" },
            { text: "Created At", value: "created_at" },
            { text: "Last Used", value: "last_used" },
            { text: "Worker ID", value: "worker_id" },
        ],
    }),
    computed: {
    },
    watch: {
    },
    created() {
    },
    methods: {
    }
};
</script>
