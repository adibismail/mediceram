<template>
<v-app>
    <div class="content-wrapper" data-app>
      <v-slide-group
        multiple
        show-arrows
      >
      <v-slide-item
      >
      <div class ="column">
        <div class="row">
            <div class="col-xl-4 col-sm-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h5>Daily Formers Passed</h5>
                        <div class="row">
                            <div class="col-9">
                                <div class="d-flex align-items-center align-self-start">
                                    <h2 class="mb-0"> {{daily_total_passed}} </h2>
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
            <div class="col-xl-4 col-sm-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h5>Daily Formers Failed</h5>
                        <div class="row">
                            <div class="col-9">
                                <div
                                    class="d-flex align-items-center align-self-start"
                                >
                                    <h2 class="mb-0"> {{daily_total_failed}} </h2>
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
            <div class="col-xl-4 col-sm-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h5>Total Moulds</h5>
                        <div class="row">
                            <div class="col-9">
                                <div
                                    class="d-flex align-items-center align-self-start"
                                >
                                    <h2 class="mb-0"> {{total_moulds}} </h2>
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
      <!-- </v-slide-item>
      <v-slide-item
      > -->
        <div class="row">
            <div class="col-md-4 col-sm-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-row justify-content-between">
                            <h4 class="card-title">Recent Former Failures</h4>
                        </div>
                        <div class="preview-list">

                            <div class="preview-item border-bottom" :items="recent_fails">
                                <div class="preview-item-content d-flex flex-grow">
                                    <div class="flex-grow">
                                        <div class="d-flex d-md-block d-xl-flex justify-content-between">
                                            <h6 class="preview-subject">
                                                Mould ID: e114n
                                            </h6>
                                            <p class="text-muted text-small"> {{recent_fails}} </p>
                                        </div>
                                        <p class="text-muted">
                                            Produced former with failure(s):
                                            <span class="badge badge-outline-danger">
                                                {{recent_fails}}
                                            </span>
                                        </p>
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
                        <v-data-table dark :headers="headers" :items="plaster_moulds" sort-by="epc" class="elevation-1 table-bg">
                            <template v-slot:top>
                                <v-toolbar class="table-bg" flat>
                                    <v-divider class="mx-4" inset vertical></v-divider>
                                    <v-spacer></v-spacer>

                                    <!-- <template v-slot:activator="{ on, attrs }">
                                        <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
                                            Export Data
                                        </v-btn>
                                    </template> -->
                                </v-toolbar>
                            </template>
                        </v-data-table>
                    </div>
                </div>

            </div>
        </div>
      </div>
      </v-slide-item>
      <v-slide-item>
        <graph :orders="orders" :customers="customers"></graph>
      </v-slide-item>
      </v-slide-group>
      
    </div>
    <!-- content-wrapper ends -->
</v-app>
</template>

<script>
import Layout from "@/Shared/Layout";
import graph from '../OrdersMonitor/View-Station.vue';

export default {
    metaInfo: { title: "Dashboard" },
    layout: Layout,
    props: ["daily_total_passed", "daily_total_failed", "total_moulds",
            "recent_fails", "plaster_moulds", "orders", "customers"],
    components: {
        graph,
    },
    data: () => ({
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
