<template>
    <div class="content-wrapper" data-app>
        <div class="row ">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">All Customers</h4>

                        <div class="alert alert-success" v-if="$page.props.flash.success_msg">
                            {{ $page.props.flash.success_msg }}
                        </div>
                        <div class="alert alert-danger" v-if="$page.props.flash.err_msg">
                            {{ $page.props.flash.err_msg }}
                        </div>

                        <!-- items= {DATA} -->
                        <v-data-table dark :headers="headers" :items="customers" sort-by="customer_id" caption="" class="elevation-1 table-bg">
                            <template v-slot:top>
                                <v-toolbar flat class="table-bg">
                                    <v-divider class="mx-4" inset vertical></v-divider>
                                    <v-spacer></v-spacer>
                                    <v-dialog v-model="dialog" max-width="500px">
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-btn class="btn btn-success btn-fw" v-bind="attrs" v-on="on">
                                                New Customer
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
                                                            <v-text-field v-model=" editedItem.customer_id" label="Customer ID">
                                                            </v-text-field>
                                                            <div class="text-danger remove-error" v-if="errors.customer_id">*{{errors.customer_id}}</div>
                                                        </v-col>
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

                                    <v-dialog v-model="dialogDelete" max-width="500px">
                                        <v-card>
                                            <v-card-title class="headline">
                                                Are you sure you want to delete this customer?
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
                                <v-icon small class="mr-2" @click="editItem(item)">
                                    mdi-pencil
                                </v-icon>
                                <v-icon small @click="deleteItem(item)">
                                    mdi-delete
                                </v-icon>
                            </template>
                        </v-data-table>
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
    metaInfo: { title: "Customers" },
    layout: Layout,
    props: ["customers", "errors"],
    mounted() {
        //console.log(this.customers[0]);
    },
    data: () => ({
        dialog: false,
        dialogDelete: false,
        headers: [
            { text: "Customer ID", value: "customer_id" },
            { text: "Actions", value: "actions", sortable: false }
        ],
        editedIndex: -1,
        editedItem: {
            customer_id: ''
        },
    }),
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? "New Customer" : "Edit Item";
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
            this.editedIndex = this.customers.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialog = true;
            $('.remove-error').css('display', 'none');
        },
        deleteItem(item) {
            this.editedIndex = this.customers.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialogDelete = true;
        },
        deleteItemConfirm() {
            this.$inertia.post(this.route('customers-delete'), this.editedItem);
            this.closeDelete();
        },
        close() {
            this.dialog = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            });
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
                this.$inertia.post(this.route('customers-update'), this.editedItem, {
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
                this.$inertia.post(this.route('customers-store'), this.editedItem, {
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
        }
    }
};
</script>
