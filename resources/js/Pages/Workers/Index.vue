<template>
    <div class="content-wrapper" data-app>
        <div class="row">
            <div class="col-md-12 mx-auto">
                <ul class="nav nav-pills nav-pills-info" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-active-workers-tab" data-toggle="pill" href="#pills-active-workers" role="tab" aria-controls="pills-active-workers" aria-selected="true"> Active Workers </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-inactive-workers-tab" data-toggle="pill" href="#pills-inactive-workers" role="tab" aria-controls="pills-inactive-workers" aria-selected="false"> Inactive Workers </a>
                    </li>
                </ul>

                <div class="tab-content tab-content-custom-pill" id="pills-tabContent">
                    <div class="tab-pane fade active show" id="pills-active-workers" role="tabpanel" aria-labelledby="pills-active-workers-tab">
                        <div class="row ">
                            <div class="col-12 grid-margin">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Active Workers</h4>

                                        <div class="alert alert-success" v-if="$page.props.flash.success_msg">
                                            {{ $page.props.flash.success_msg }}
                                        </div>
                                        <div class="alert alert-danger" v-if="$page.props.flash.err_msg">
                                            {{ $page.props.flash.err_msg }}
                                        </div>

                                        <!-- items= {DATA} -->
                                        <v-data-table dark :headers="headers_active" :items="active_workers" sort-by="worker_id" caption="" class="elevation-1 table-bg">
                                            <template v-slot:item.status="{ item }">
                                                <div v-if = "item.status == '0'"> Inactive </div>
                                                <div v-else> Active </div>
                                            </template>
                                            <template v-slot:top>
                                                <v-toolbar flat class="table-bg">
                                                    <v-divider class="mx-4" inset vertical></v-divider>
                                                    <v-spacer></v-spacer>
                                                    <v-dialog v-model="dialog" max-width="500px">
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <v-btn class="btn btn-success btn-fw" v-bind="attrs" v-on="on">
                                                                New Worker
                                                            </v-btn>
                                                        </template>
                                                        <v-card>
                                                            <v-card-title>
                                                                <span class="headline">{{ formTitle }}</span>
                                                            </v-card-title>

                                                            <v-card-text>
                                                                <v-container>
                                                                    <v-row>
                                                                        <v-col cols="12" sm="12" md="12">
                                                                            <v-text-field v-model="editedItem.worker_id" 
                                                                            label="Worker ID" 
                                                                            @keydown.space.prevent
                                                                            :disabled="disabled">
                                                                            </v-text-field>
                                                                            <div class="text-danger remove-error" v-if="errors.worker_id">*{{errors.worker_id}}</div>
                                                                        </v-col>
                                                                    </v-row>
                                                                    <v-row>
                                                                        <v-col cols="12" sm="12" md="12">
                                                                            <v-text-field v-model="editedItem.worker_name" label="Worker Name" :disabled="disabled">
                                                                            </v-text-field>
                                                                            <div class="text-danger remove-error" v-if="errors.worker_name">*{{errors.worker_name}}</div>
                                                                        </v-col>
                                                                    </v-row>
                                                                    <v-row>
                                                                        <v-col cols="12" sm="12" md="12">
                                                                            <v-select v-model="selectedDepartment.dprt_name" 
                                                                            :items="departments" 
                                                                            item-text="dprt_name" 
                                                                            label="Assign Department"
                                                                            :disabled="disabled"
                                                                            persistent-hint return-object single-line></v-select>
                                                                            <div class="text-danger remove-error" v-if="errors.dprt_tbl_id">*{{errors.dprt_tbl_id}}</div>

                                                                            <!-- <v-select v-model="selectedDepartment.dprt_name" :items="departments"item-text="dprt_name" menu-props="auto" label="Assign Department" hide-details single-line></v-select>
                                                                            <div class="text-danger remove-error" v-if="errors.dprt_tbl_id">*{{errors.dprt_tbl_id}}</div> -->
                                                                        </v-col>
                                                                    </v-row>
                                                                    <v-row style="margin-top: 25px;">
                                                                        <v-checkbox v-model="beacon_enabled" hide-details></v-checkbox>
                                                                        <v-select v-model="selectedBeacon" :items="availBeacons" :disabled="!beacon_enabled" menu-props="auto" label="Assign Beacon" hide-details prepend-icon="mdi-card-text" single-line @click="getAvailBeacons"></v-select>
                                                                    </v-row>
                                                                </v-container>
                                                            </v-card-text>

                                                            <v-card-actions>
                                                                <v-spacer></v-spacer>
                                                                <v-btn class="btn btn-secondary btn-fw" text @click="close">
                                                                    Cancel
                                                                </v-btn>
                                                                <v-btn class="btn btn-success btn-fw" text @click="save">
                                                                    Save
                                                                </v-btn>
                                                            </v-card-actions>
                                                        </v-card>
                                                    </v-dialog>
                                                    <v-dialog v-model="dialogDelete" max-width="600px">
                                                        <v-card>
                                                            <v-card-title class="headline">
                                                                Are you sure you want to deactivate this worker?
                                                            </v-card-title>
                                                            <v-card-actions>
                                                                <v-spacer></v-spacer>
                                                                <v-btn color="blue darken-1" text @click="closeDelete">
                                                                    Cancel
                                                                </v-btn>
                                                                <v-btn color="blue darken-1" text @click="deleteItemConfirm">
                                                                    OK
                                                                </v-btn>
                                                                <v-spacer></v-spacer>
                                                            </v-card-actions>
                                                        </v-card>
                                                    </v-dialog>
                                                </v-toolbar>
                                            </template>
                                            <template v-slot:item.actions="{ item }">
                                                <template v-if="item.status == 1">
                                                    <v-tooltip bottom>
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <span v-bind="attrs" v-on="on">
                                                                <v-icon small class="mr-2" @click="editItem(item)">
                                                                    mdi-pencil
                                                                </v-icon>
                                                            </span>
                                                        </template>
                                                        <span>Edit Worker</span>
                                                    </v-tooltip>
                                                    <v-tooltip bottom>
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <span v-bind="attrs" v-on="on">
                                                                <v-icon small @click="deleteItem(item)">
                                                                    mdi-account-off
                                                                </v-icon>
                                                            </span>
                                                        </template>
                                                        <span>Deactivate Worker</span>
                                                    </v-tooltip>
                                                </template>
                                            </template>
                                        </v-data-table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-inactive-workers" role="tabpanel" aria-labelledby="pills-inactive-workers-tab">
                        <div class="row ">
                            <div class="col-12 grid-margin">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Inactive Workers</h4>

                                        <!-- items= {DATA} -->
                                        <v-data-table dark :headers="headers_inactive" :items="inactive_workers" sort-by="worker_id" caption="" class="elevation-1 table-bg">
                                            <template v-slot:item.status="{ item }">
                                                <div v-if = "item.status == '0'"> Inactive </div>
                                                <div v-else> Active </div>
                                            </template>
                                        </v-data-table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
</template>

<script>
import Layout from "@/Shared/Layout";

export default {
    metaInfo: { title: "Workers" },
    layout: Layout,
    props: ["active_workers", "inactive_workers", "beacons", "departments", "errors"],
    mounted() {
        //console.log(this.workers[0]);
    },
    data: () => ({
        beacon_enabled: true,
        dialog: false,
        dialogDelete: false,
        headers_active: [
            { text: "Worker ID", value: "worker_id" },
            { text: "Worker Name", value: "worker_name" },
            { text: "Department", value: "dprt_name" },
            { text: "Beacon ID", value: "beacon_id" },
            { text: "Status", value: "status" },
            { text: "Actions", value: "actions", sortable: false }
        ],
        headers_inactive: [
            { text: "Worker ID", value: "worker_id" },
            { text: "Worker Name", value: "worker_name" },
            { text: "Department", value: "dprt_name" },
            { text: "Status", value: "status" },
        ],
        editedIndex: -1,
        editedItem: {
            worker_id: '',
            worker_name: '',
            beacon_id: '',
            dprt_name: '',
        },
        selectedDepartment: [],
        selectedBeacon: '',
        availBeacons: [],
        disabled: "false",
    }),
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? "New Worker" : "Edit Worker";
        }
    },
    watch: {
        dialog(val) {
            val || this.close();
        },
        dialogDelete(val) {
            val || this.closeDelete();
        }
    },
    created() {
        //this.initialize();
    },
    methods: {
        editItem(item) {
            item.beacon_id != null ? this.availBeacons.push(item.beacon_id) : '';
            this.selectedBeacon = item.beacon_id;
            this.selectedDepartment.dprt_tbl_id = item.dprt_tbl_id;
            this.selectedDepartment.dprt_name = item.dprt_name;
            this.editedIndex = this.active_workers.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.editedItem.new_beacon_id = this.selectedBeacon;
            this.disabled = true,
            this.dialog = true;
            $('.remove-error').css('display', 'none');
        },
        deleteItem(item) {
            this.editedIndex = this.active_workers.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialogDelete = true;
        },
        deleteItemConfirm() {
            this.$inertia.post(this.route('workers-delete'), this.editedItem);
            this.active_workers.splice(this.editedIndex, 1);
            this.closeDelete();
        },
        close() {
            this.disabled = false,
            this.dialog = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            });
            this.beacon_enabled = true;
            this.selectedBeacon = "";
            this.selectedDepartment = [];
            $('.remove-error').css('display', 'none');
        },
        closeDelete() {
            this.dialogDelete = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            });
        },
        save() {
            if (this.editedIndex > -1) {
                
                this.beacon_enabled === false ? this.editedItem.new_beacon_id = "" : this.editedItem.new_beacon_id = this.selectedBeacon;
                console.log(this.editedItem)
                console.log(this.selectedDepartment)

                // if assign new beacon
                // if change name
                // if assign new beacon & change name

                //check if it's saving the same beacon ids
                //only assigning another beacon/unassigning beacon will make the post request
                if (this.editedItem.beacon_id != this.editedItem.new_beacon_id) {
                    console.log("Beacon Reassigned")
                    this.$inertia.post(this.route('workers-update'), this.editedItem, {
                        onSuccess: () => {
                            // Handle success event
                            this.close();
                        },
                        onError: (errors) => {
                            // Handle validation errors
                            $('.remove-error').css('display', 'block');
                        },
                    })
                }
            } else {
                this.editedItem.beacon_id = this.selectedBeacon;
                this.editedItem.dprt_name = this.selectedDepartment.dprt_name ? this.selectedDepartment.dprt_name.dprt_name : "";
                this.editedItem.dprt_tbl_id = this.selectedDepartment.dprt_name ? this.selectedDepartment.dprt_name.dprt_tbl_id : "";

                this.$inertia.post(this.route('workers-store'), this.editedItem, {
                    onSuccess: () => {
                        // Handle success event
                        this.close();
                    },
                    onError: (errors) => {
                        // Handle validation errors
                        $('.remove-error').css('display', 'block');
                    },
                })
            }
        },
        getAvailBeacons() {
            this.axios.get(this.route('get-avail-beacons')).then((response) => {
                var beacons = [];
                $.each(response.data.avail_beacons, function(key, value) {
                   beacons.push(value.beacon_id)
                });
                this.availBeacons = beacons;
            })
        },
    }
};
</script>
