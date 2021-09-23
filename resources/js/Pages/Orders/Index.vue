<template>
    <div class="content-wrapper" data-app>
        <div class="row">
            <div class="col-md-12 mx-auto">
                <ul class="nav nav-pills nav-pills-info" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-incomplete-orders-tab" data-toggle="pill" href="#pills-incomplete-orders" role="tab" aria-controls="pills-incomplete-orders" aria-selected="true"> Incomplete Orders </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-upcoming-orders-tab" data-toggle="pill" href="#pills-upcoming-orders" role="tab" aria-controls="pills-upcoming-orders" aria-selected="false"> Upcoming Orders </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-completed-orders-tab" data-toggle="pill" href="#pills-completed-orders" role="tab" aria-controls="pills-completed-orders" aria-selected="false"> Completed Orders </a>
                    </li>
                </ul>

                <div class="tab-content tab-content-custom-pill" id="pills-tabContent">
                    <div class="tab-pane fade active show" id="pills-incomplete-orders" role="tabpanel" aria-labelledby="pills-incomplete-orders-tab">
                        <div class="row ">
                            <div class="col-12 grid-margin">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Incomplete Orders</h4>

                                        <!-- <div class="alert alert-fill-info" role="alert">
                                            <i class="mdi mdi-alert-circle"></i> On-going orders will not be able to delete, it is advised to edit the 'Order Quantity' in order to terminate the order. 
                                        </div> -->
                                        
                                        <div class="alert alert-success" v-if="$page.props.flash.success_msg">
                                            {{ $page.props.flash.success_msg }}
                                        </div>
                                        <div class="alert alert-danger" v-if="$page.props.flash.err_msg">
                                            {{ $page.props.flash.err_msg }}
                                        </div>
                                        
                                        <v-data-table dark :headers="headers_incomplete" :items="incomplete_orders" sort-by="prod_date" caption="" class="elevation-1 table-bg">
                                            
                                            <!-- <template v-slot:item.order_tbl_id="{ item }">
                                                <v-btn rounded class="btn btn-outline-info btn-icon-text" dark @click="exportExcel(item.order_tbl_id)">
                                                    Export
                                                </v-btn>
                                            </template> -->
                                            
                                            <template v-slot:top>
                                                <v-toolbar flat class="table-bg">
                                                    <v-divider class="mx-4" inset vertical
                                                    ></v-divider>
                                                    <v-spacer></v-spacer>
                                                    
                                                    <v-dialog v-model="dialog" max-width="600px" style="z-index:1050;">
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <v-btn class="btn btn-success btn-fw" v-bind="attrs" v-on="on">
                                                                New Order
                                                            </v-btn>
                                                        </template>
                                                        <v-card>
                                                            <v-card-title>
                                                                <span class="headline">{{ formTitle }}</span>
                                                            </v-card-title>

                                                            <v-form @submit.prevent="save()" ref="form">
                                                                <v-card-text>
                                                                    <v-container>
                                                                        <v-row>
                                                                            <v-col cols="12" sm="12" md="12">
                                                                                <v-menu v-model="datepickerMenu" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
                                                                                    <template v-slot:activator="{ on, attrs }">
                                                                                        <v-text-field v-model="selectedProdDate" label="Production Date" prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" ></v-text-field>
                                                                                    </template>
                                                                                    <v-date-picker :min='new Date().toISOString().substr(0, 10)' v-model="selectedProdDate" @input="menu2 = false"></v-date-picker>
                                                                                </v-menu>
                                                                            </v-col>
                                                                        </v-row>
                                                                        <v-row>
                                                                            <v-col cols="12" sm="12" md="12">
                                                                                <v-select v-model="selectedCustomer.customer_id"
                                                                                    :items="customers" item-text="customer_id" label="Select a Customer" persistent-hint return-object single-line 
                                                                                ></v-select>
                                                                                <div class="text-danger remove-error" v-if="errors.customer_tbl_id">*{{errors.customer_tbl_id}}</div>
                                                                            </v-col>
                                                                        </v-row>
                                                                        <v-row>
                                                                            <v-col cols="12" sm="12" md="12">
                                                                                <v-select v-model="selectedMouldModel.mould_mdl_id" :items="mould_models" item-text="mould_mdl_id" label="Select a Mould Model" persistent-hint return-object single-line></v-select>
                                                                                <div class="text-danger remove-error" v-if="errors.mould_mdl_tbl_id">*{{errors.mould_mdl_tbl_id}}</div>
                                                                            </v-col>
                                                                        </v-row>
                                                                        <v-row>
                                                                            <v-col cols="12" sm="6" md="6">
                                                                                <v-text-field v-model="editedItem.fmr_opt_wgt_min" type="text" v-mask="'####.##'" placeholder="0000.00" label="Former Min Weight">
                                                                                </v-text-field>
                                                                                <div class="text-danger remove-error" v-if="errors.fmr_opt_wgt_min">*{{errors.fmr_opt_wgt_min}}</div>
                                                                            </v-col>
                                                                            <v-col cols="12" sm="6" md="6">
                                                                                <v-text-field v-model=" editedItem.fmr_opt_wgt_max" type="text" v-mask="'####.##'" placeholder="9999.99" label="Former Max Weight">
                                                                                </v-text-field>
                                                                                <div class="text-danger remove-error" v-if="errors.fmr_opt_wgt_max">*{{errors.fmr_opt_wgt_max}}</div>
                                                                            </v-col>
                                                                        </v-row>
                                                                        <v-row>
                                                                            <v-col cols="12" sm="6" md="12">
                                                                                <v-text-field v-model="editedItem.order_qty" type="text" v-mask="'######'" placeholder="999999" label="Former Quantity">
                                                                                </v-text-field>
                                                                                <div class="text-danger remove-error" v-if="errors.order_qty">*{{errors.order_qty}}</div>
                                                                            </v-col>
                                                                        </v-row>
                                                                        <v-row>
                                                                            <v-col cols="12" sm="12" md="12">
                                                                                <v-select v-model="selectedCastingStation.casting_station_id"
                                                                                    :items="casting_stations" item-text="casting_station_id" label="Select a Casting Station" persistent-hint return-object single-line
                                                                                ></v-select>
                                                                                <div class="text-danger remove-error" v-if="errors.cs_tbl_id">*{{errors.cs_tbl_id}}</div>
                                                                            </v-col>
                                                                        </v-row>
                                                                    </v-container>
                                                                </v-card-text>

                                                                <v-card-actions>
                                                                    <v-spacer></v-spacer>
                                                                    <v-btn class="btn btn-secondary btn-fw" text @click="close">
                                                                        Cancel
                                                                    </v-btn>
                                                                    <v-btn type="submit" class="btn btn-success btn-fw" text>Save</v-btn>
                                                                </v-card-actions>
                                                            </v-form>
                                                        </v-card>
                                                    </v-dialog>

                                                    <v-dialog v-model="dialogDelete" max-width="500px">
                                                        <v-card>
                                                            <v-card-title class="headline">
                                                                Are you sure you want to delete this order?
                                                            </v-card-title>
                                                            <v-card-actions>
                                                                <v-spacer></v-spacer>
                                                                <v-btn color="blue darken-1" text @click="closeDelete">
                                                                    Cancel
                                                                </v-btn>
                                                                <v-btn color="blue darken-1" text  @click="deleteItemConfirm">
                                                                    OK
                                                                </v-btn>
                                                                <v-spacer></v-spacer>
                                                            </v-card-actions>
                                                        </v-card>
                                                    </v-dialog>
                                                </v-toolbar>
                                            </template>
                                            <template v-slot:item.actions="{ item }">
                                                <template v-if="item.done_qty == 0">
                                                    <v-tooltip bottom>
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <span v-bind="attrs" v-on="on">
                                                                <v-icon small class="mr-2" @click="editItem(item)">
                                                                    mdi-pencil
                                                                </v-icon>
                                                            </span>
                                                        </template>
                                                        <span>Edit Order</span>
                                                    </v-tooltip>
                                                </template>
                                                <v-tooltip bottom>
                                                    <template v-slot:activator="{ on, attrs }">
                                                        <span v-bind="attrs" v-on="on">
                                                            <v-icon small @click="deleteItem(item)">
                                                                mdi-delete
                                                            </v-icon>
                                                        </span>
                                                    </template>
                                                    <span>Delete Order</span>
                                                </v-tooltip>
                                                

                                            </template>
                                        </v-data-table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-upcoming-orders" role="tabpanel" aria-labelledby="pills-upcoming-orders-tab">
                        <div class="row ">
                            <div class="col-12 grid-margin">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Upcoming Orders</h4>
                                        
                                        <div class="alert alert-success" v-if="$page.props.flash.success_msg">
                                            {{ $page.props.flash.success_msg }}
                                        </div>
                                        <div class="alert alert-danger" v-if="$page.props.flash.err_msg">
                                            {{ $page.props.flash.err_msg }}
                                        </div>
                                        
                                        <v-data-table dark :headers="headers_upcoming" :items="upcoming_orders" sort-by="prod_date" caption="" class="elevation-1 table-bg">
                                            <template v-slot:top>
                                                <v-toolbar flat class="table-bg">
                                                    <v-divider class="mx-4" inset vertical
                                                    ></v-divider>
                                                    <v-spacer></v-spacer>
                                                    
                                                    <v-dialog v-model="dialog2" max-width="600px" style="z-index:1050;">
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <v-btn class="btn btn-success btn-fw" v-bind="attrs" v-on="on">
                                                                New Order
                                                            </v-btn>
                                                        </template>
                                                        <v-card>
                                                            <v-card-title>
                                                                <span class="headline">{{ formTitle }}</span>
                                                            </v-card-title>

                                                            <v-form @submit.prevent="save2()" ref="form">
                                                                <v-card-text>
                                                                    <v-container>
                                                                        <v-row>
                                                                            <v-col cols="12" sm="12" md="12">
                                                                                <v-menu v-model="datepickerMenu2" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
                                                                                    <template v-slot:activator="{ on, attrs }">
                                                                                        <v-text-field v-model="selectedProdDate" label="Production Date" prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" ></v-text-field>
                                                                                    </template>
                                                                                    <v-date-picker :min='new Date().toISOString().substr(0, 10)' v-model="selectedProdDate" @input="menu2 = false"></v-date-picker>
                                                                                </v-menu>
                                                                            </v-col>
                                                                        </v-row>
                                                                        <v-row>
                                                                            <v-col cols="12" sm="12" md="12">
                                                                                <v-select v-model="selectedCustomer.customer_id"
                                                                                    :items="customers" item-text="customer_id" label="Select a Customer" persistent-hint return-object single-line 
                                                                                ></v-select>
                                                                                <div class="text-danger remove-error" v-if="errors.customer_tbl_id">*{{errors.customer_tbl_id}}</div>
                                                                            </v-col>
                                                                        </v-row>
                                                                        <v-row>
                                                                            <v-col cols="12" sm="12" md="12">
                                                                                <v-select v-model="selectedMouldModel.mould_mdl_id" :items="mould_models" item-text="mould_mdl_id" label="Select a Mould Model" persistent-hint return-object single-line></v-select>
                                                                                <div class="text-danger remove-error" v-if="errors.mould_mdl_tbl_id">*{{errors.mould_mdl_tbl_id}}</div>
                                                                            </v-col>
                                                                        </v-row>
                                                                        <v-row>
                                                                            <v-col cols="12" sm="6" md="6">
                                                                                <v-text-field v-model="editedItem.fmr_opt_wgt_min" type="text" v-mask="'####.##'" placeholder="0000.00" label="Former Min Weight">
                                                                                </v-text-field>
                                                                                <div class="text-danger remove-error" v-if="errors.fmr_opt_wgt_min">*{{errors.fmr_opt_wgt_min}}</div>
                                                                            </v-col>
                                                                            <v-col cols="12" sm="6" md="6">
                                                                                <v-text-field v-model=" editedItem.fmr_opt_wgt_max" type="text" v-mask="'####.##'" placeholder="9999.99" label="Former Max Weight">
                                                                                </v-text-field>
                                                                                <div class="text-danger remove-error" v-if="errors.fmr_opt_wgt_max">*{{errors.fmr_opt_wgt_max}}</div>
                                                                            </v-col>
                                                                        </v-row>
                                                                        <v-row>
                                                                            <v-col cols="12" sm="6" md="12">
                                                                                <v-text-field v-model="editedItem.order_qty" type="text" v-mask="'######'" placeholder="999999" label="Former Quantity">
                                                                                </v-text-field>
                                                                                <div class="text-danger remove-error" v-if="errors.order_qty">*{{errors.order_qty}}</div>
                                                                            </v-col>
                                                                        </v-row>
                                                                        <v-row>
                                                                            <v-col cols="12" sm="12" md="12">
                                                                                <v-select v-model="selectedCastingStation.casting_station_id"
                                                                                    :items="casting_stations" item-text="casting_station_id" label="Select a Casting Station" persistent-hint return-object single-line
                                                                                ></v-select>
                                                                                <div class="text-danger remove-error" v-if="errors.cs_tbl_id">*{{errors.cs_tbl_id}}</div>
                                                                            </v-col>
                                                                        </v-row>
                                                                    </v-container>
                                                                </v-card-text>

                                                                <v-card-actions>
                                                                    <v-spacer></v-spacer>
                                                                    <v-btn class="btn btn-secondary btn-fw" text @click="close2">
                                                                        Cancel
                                                                    </v-btn>
                                                                    <v-btn type="submit" class="btn btn-success btn-fw" text>Save</v-btn>
                                                                </v-card-actions>
                                                            </v-form>
                                                        </v-card>
                                                    </v-dialog>
                                                    <!-- </v-form> -->

                                                    <v-dialog v-model="dialogDelete2" max-width="500px">
                                                        <v-card>
                                                            <v-card-title class="headline">
                                                                Are you sure you want to archive this order?
                                                            </v-card-title>
                                                            <v-card-actions>
                                                                <v-spacer></v-spacer>
                                                                <v-btn color="blue darken-1" text @click="closeDelete2">
                                                                    Cancel
                                                                </v-btn>
                                                                <v-btn color="blue darken-1" text  @click="deleteItemConfirm2">
                                                                    OK
                                                                </v-btn>
                                                                <v-spacer></v-spacer>
                                                            </v-card-actions>
                                                        </v-card>
                                                    </v-dialog>
                                                </v-toolbar>
                                            </template>
                                            <template v-slot:item.actions="{ item }">
                                                <v-icon small class="mr-2" @click="editItem2(item)">
                                                    mdi-pencil
                                                </v-icon>
                                                <v-icon small @click="deleteItem2(item)">
                                                    mdi-delete
                                                </v-icon>
                                            </template>
                                        </v-data-table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-completed-orders" role="tabpanel" aria-labelledby="pills-completed-orders-tab">
                        <div class="row ">
                            <div class="col-12 grid-margin">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Completed Orders</h4>
                                        <v-data-table dark :headers="headers_completed" :items="completed_orders" sort-by="prod_date" caption="" class="elevation-1 table-bg">
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
</template>

<script>
import Layout from "@/Shared/Layout";
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';

export default {
    metaInfo: { title: "Orders" },
    layout: Layout,
    components: { DatePicker },
    props: ["incomplete_orders", "upcoming_orders", "completed_orders", "customers", "mould_models", "casting_stations", "errors"],
    mounted() {
        //console.log(this.mould_models);
    },
    data: () => ({
        dialog: false,
        dialog2: false,
        datepickerMenu: false,
        datepickerMenu2: false,
        dialogDelete: false,
        dialogDelete2: false,
        headers_incomplete: [
            { text: "Table ID", value: "order_tbl_id" },
            { text: "Production Date", value: "prod_date" },
            { text: "Customer ID", value: "customer_id" },
            { text: "Mould Model ID", value: "mould_mdl_id" },
            { text: "Casting Station ID", value: "casting_station_id" },
            { text: "Minimum Weight(g)", value: "fmr_opt_wgt_min" },
            { text: "Maximum Weight(g)xxx", value: "fmr_opt_wgt_max" },
            { text: "Order Quantity", value: "order_qty" },
            { text: "Done Quantity", value: "done_qty" },
            // { text: "Export Excel", value: "order_tbl_id" },
            { text: "Actions", value: "actions", sortable: false }
        ],
        headers_upcoming: [
            { text: "Production Date", value: "prod_date" },
            { text: "Customer ID", value: "customer_id" },
            { text: "Mould Model ID", value: "mould_mdl_id" },
            { text: "Casting Station ID", value: "casting_station_id" },
            { text: "Former Minimum Weight", value: "fmr_opt_wgt_min" },
            { text: "Former Maximum Weight", value: "fmr_opt_wgt_max" },
            { text: "Order Quantity", value: "order_qty" },
            { text: "Done Quantity", value: "done_qty" },
            { text: "Actions", value: "actions", sortable: false }
        ],
        headers_completed: [
            { text: "Production Date", value: "prod_date" },
            { text: "Customer ID", value: "customer_id" },
            { text: "Mould Model ID", value: "mould_mdl_id" },
            { text: "Casting Station ID", value: "casting_station_id" },
            { text: "Former Minimum Weight", value: "fmr_opt_wgt_min" },
            { text: "Former Maximum Weight", value: "fmr_opt_wgt_max" },
            { text: "Order Quantity", value: "order_qty" },
            { text: "Done Quantity", value: "done_qty" },
        ],
        editedIndex: -1,
        editedItem: {
            prod_date: '',
            customer_id: '',
            mould_mdl_id: '',
            casting_station_id: '',
            fmr_opt_wgt_min: '',
            fmr_opt_wgt_max: '',
            order_qty: '',
        },
        prod_datetime: [],
        selectedProdDate: new Date().toISOString().substr(0, 10),
        selectedCustomer: [],
        selectedMouldModel: [],
        selectedCastingStation: []
    }),
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? "New Order" : "Edit Item";
        },
    },
    watch: {
        dialog(val) {
            val || this.close();
        },
        dialogDelete(val) {
            val || this.closeDelete();
        },
        dialog2(val) {
            val || this.close();
        },
        dialogDelete2(val) {
            val || this.closeDelete();
        }
    },
    created() {
        // this.initialize();
    },
    methods: {
        //Disabled exportExcel, left the code commented incase it is required in the future
        // exportExcel(id) {
        //     window.open(this.route('orders-export', id))
        //     // window.open(this.route('orders-export') + '/' + id)
        // },
        editItem(item) {
            this.selectedCustomer.customer_id = item.customer_id;
            this.selectedCustomer.customer_tbl_id = item.customer_tbl_id;
            this.selectedMouldModel.mould_mdl_id = item.mould_mdl_id;
            this.selectedMouldModel.mould_mdl_tbl_id = item.mould_mdl_tbl_id;
            this.selectedCastingStation.casting_station_id = item.casting_station_id;
            this.selectedCastingStation.cs_tbl_id = item.cs_tbl_id;
            this.selectedProdDate = item.prod_date;
            this.editedIndex = this.incomplete_orders.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialog = true;
            $('.remove-error').css('display', 'none');
        },
        deleteItem(item) {
            this.editedIndex = this.incomplete_orders.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialogDelete = true;
        },
        deleteItemConfirm() {
            this.$inertia.post(this.route('orders-delete'), this.editedItem);
            this.incomplete_orders.splice(this.editedIndex, 1);
            this.closeDelete();
        },
        close() {
            this.dialog = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            });
            $('.remove-error').css('display', 'none');
            this.selectedProdDate = new Date().toISOString().substr(0, 10);
            this.selectedMouldModel = [];
            this.selectedCastingStation = [];
            this.selectedCustomer = [];
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
                this.editedItem.prod_date = this.selectedProdDate;
                this.editedItem.mould_mdl_id = this.selectedMouldModel.mould_mdl_id.mould_mdl_id ? this.selectedMouldModel.mould_mdl_id.mould_mdl_id : this.selectedMouldModel.mould_mdl_id;
                this.editedItem.mould_mdl_tbl_id = this.selectedMouldModel.mould_mdl_id.mould_mdl_tbl_id ? this.selectedMouldModel.mould_mdl_id.mould_mdl_tbl_id : this.selectedMouldModel.mould_mdl_tbl_id;
                this.editedItem.casting_station_id = this.selectedCastingStation.casting_station_id.casting_station_id ? this.selectedCastingStation.casting_station_id.casting_station_id : this.selectedCastingStation.casting_station_id;
                this.editedItem.cs_tbl_id = this.selectedCastingStation.casting_station_id.cs_tbl_id ? this.selectedCastingStation.casting_station_id.cs_tbl_id : this.selectedCastingStation.cs_tbl_id;
                this.editedItem.customer_id = this.selectedCustomer.customer_id.customer_id ? this.selectedCustomer.customer_id.customer_id : this.selectedCustomer.customer_id;
                this.editedItem.customer_tbl_id = this.selectedCustomer.customer_id.customer_tbl_id ? this.selectedCustomer.customer_id.customer_tbl_id : this.selectedCustomer.customer_tbl_id;
                
                this.$inertia.post(this.route('orders-update'), this.editedItem, {
                    onSuccess: () => {
                        // Handle success event
                        this.close();
                    },
                    onError: (errors) => {
                        // Handle validation errors
                        $('.remove-error').css('display', 'block');
                    },
                })
            } else {
                this.editedItem.prod_date = this.selectedProdDate;
                this.editedItem.mould_mdl_id = this.selectedMouldModel.mould_mdl_id ? this.selectedMouldModel.mould_mdl_id.mould_mdl_id : "";
                this.editedItem.mould_mdl_tbl_id = this.selectedMouldModel.mould_mdl_id ? this.selectedMouldModel.mould_mdl_id.mould_mdl_tbl_id : "";
                this.editedItem.casting_station_id = this.selectedCastingStation.casting_station_id ? this.selectedCastingStation.casting_station_id.casting_station_id : "";
                this.editedItem.cs_tbl_id = this.selectedCastingStation.casting_station_id ? this.selectedCastingStation.casting_station_id.cs_tbl_id : "";
                this.editedItem.customer_id = this.selectedCustomer.customer_id ? this.selectedCustomer.customer_id.customer_id : "";
                this.editedItem.customer_tbl_id = this.selectedCustomer.customer_id ? this.selectedCustomer.customer_id.customer_tbl_id : "";

                this.$inertia.post(this.route('orders-store'), this.editedItem, {
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
        editItem2(item) {
            this.selectedCustomer.customer_id = item.customer_id;
            this.selectedCustomer.customer_tbl_id = item.customer_tbl_id;
            this.selectedMouldModel.mould_mdl_id = item.mould_mdl_id;
            this.selectedMouldModel.mould_mdl_tbl_id = item.mould_mdl_tbl_id;
            this.selectedCastingStation.casting_station_id = item.casting_station_id;
            this.selectedCastingStation.cs_tbl_id = item.cs_tbl_id;
            this.selectedProdDate = item.prod_date;
            this.editedIndex = this.upcoming_orders.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialog2 = true;
            $('.remove-error').css('display', 'none');
        },
        deleteItem2(item) {
            this.editedIndex = this.upcoming_orders.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialogDelete2 = true;
        },
        deleteItemConfirm2() {
            this.$inertia.post(this.route('orders-delete'), this.editedItem);
            this.upcoming_orders.splice(this.editedIndex, 1);
            this.closeDelete2();
        },
        close2() {
            this.dialog2 = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            });
            $('.remove-error').css('display', 'none');
            this.selectedProdDate = new Date().toISOString().substr(0, 10);
            this.selectedMouldModel = [];
            this.selectedCastingStation = [];
            this.selectedCustomer = [];
        },
        closeDelete2() {
            this.dialogDelete2 = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            });
        },
        save2() {
            if (this.editedIndex > -1) {
                this.editedItem.prod_date = this.selectedProdDate;
                this.editedItem.mould_mdl_id = this.selectedMouldModel.mould_mdl_id.mould_mdl_id ? this.selectedMouldModel.mould_mdl_id.mould_mdl_id : this.selectedMouldModel.mould_mdl_id;
                this.editedItem.mould_mdl_tbl_id = this.selectedMouldModel.mould_mdl_id.mould_mdl_tbl_id ? this.selectedMouldModel.mould_mdl_id.mould_mdl_tbl_id : this.selectedMouldModel.mould_mdl_tbl_id;
                this.editedItem.casting_station_id = this.selectedCastingStation.casting_station_id.casting_station_id ? this.selectedCastingStation.casting_station_id.casting_station_id : this.selectedCastingStation.casting_station_id;
                this.editedItem.cs_tbl_id = this.selectedCastingStation.casting_station_id.cs_tbl_id ? this.selectedCastingStation.casting_station_id.cs_tbl_id : this.selectedCastingStation.cs_tbl_id;
                this.editedItem.customer_id = this.selectedCustomer.customer_id.customer_id ? this.selectedCustomer.customer_id.customer_id : this.selectedCustomer.customer_id;
                this.editedItem.customer_tbl_id = this.selectedCustomer.customer_id.customer_tbl_id ? this.selectedCustomer.customer_id.customer_tbl_id : this.selectedCustomer.customer_tbl_id;
                
                this.$inertia.post(this.route('orders-update'), this.editedItem, {
                    onSuccess: () => {
                        // Handle success event
                        this.close2();
                    },
                    onError: (errors) => {
                        // Handle validation errors
                        $('.remove-error').css('display', 'block');
                    },
                })
            } else {
                this.editedItem.prod_date = this.selectedProdDate;
                this.editedItem.mould_mdl_id = this.selectedMouldModel.mould_mdl_id ? this.selectedMouldModel.mould_mdl_id.mould_mdl_id : "";
                this.editedItem.mould_mdl_tbl_id = this.selectedMouldModel.mould_mdl_id ? this.selectedMouldModel.mould_mdl_id.mould_mdl_tbl_id : "";
                this.editedItem.casting_station_id = this.selectedCastingStation.casting_station_id ? this.selectedCastingStation.casting_station_id.casting_station_id : "";
                this.editedItem.cs_tbl_id = this.selectedCastingStation.casting_station_id ? this.selectedCastingStation.casting_station_id.cs_tbl_id : "";
                this.editedItem.customer_id = this.selectedCustomer.customer_id ? this.selectedCustomer.customer_id.customer_id : "";
                this.editedItem.customer_tbl_id = this.selectedCustomer.customer_id ? this.selectedCustomer.customer_id.customer_tbl_id : "";

                this.$inertia.post(this.route('orders-store'), this.editedItem, {
                    onSuccess: () => {
                        // Handle success event
                        this.close2();
                    },
                    onError: (errors) => {
                        // Handle validation errors
                        $('.remove-error').css('display', 'block');
                    },
                })
            }
        },
    }
};
</script>
