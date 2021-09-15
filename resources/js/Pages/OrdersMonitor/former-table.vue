<template>
    <div class="content-wrapper" data-app>
        <div class="row ">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Former Data</h4>

                        <div class="row" style="margin: 8px; padding-left: 15px; align-items: center">
                            <span style="padding-right: 15px">Select Customer: </span>
                            <v-select-graph label="customer_id" @input="onSelectCust" :options="this.customers" :clearable="false"></v-select-graph>
                            <span style="padding-left: 15px; padding-right: 15px">Select Mould Type: </span>
                            <v-select-graph label="mould_description" @input="onSelectMould" :disabled="disabled" :options="this.cust_select" :clearable="false"></v-select-graph>

                            <div style="display: flex; justify-content: flex-end; flex-grow: 4;">
                              <download-excel style=""
                                class="btn btn-success btn-fw"
                                :data="formers"
                                :fields="json_fields"
                                worksheet="My Worksheet"
                                :name="file_name"
                                type="csv"
                              > Export
                              </download-excel>
                            </div>
                        </div>

                        <!-- items= {DATA} -->
                        <v-data-table dark
                            :headers="headers"
                            :items="formers"
                            :items-per-page="5"
                            :loading="isLoadingTable"
                            class="elevation-1 table-bg"
                        ></v-data-table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
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
}

.style-chooser .vs__clear,
.style-chooser .vs__open-indicator {
  fill: #394066;
}

.vs__dropdown-menu {
  background:#1B2634;
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

export default {
    metaInfo: { title: "Mould Models" },
    layout: Layout,
    props: ["customers", "orders"],
    mounted() {
    },
    data: () => ({
        cust_select: [],
        disabled: true,
        headers: [
            {
            text: 'ID',
            align: 'start',
            sortable: false,
            value: 'former_tbl_id',
            },
            { text: 'Weight', value: 'former_weight' },
            { text: 'Created At', value: 'created_at' },
            { text: 'Max Weight', value: 'max' },
            { text: 'Min Weight', value: 'min' },
            // { text: 'QC Code', value: 'qc_code_tbl_id' },
            // { text: 'Casting Station', value: 'cs_tbl_id' },
            // { text: 'Beacon', value: 'beacon_tbl_id' },
            // { text: 'Order', value: 'order_tbl_id' },
        ],
        formers: [
        ],
        json_fields: {
          "ID": "former_tbl_id",
          Weight: "former_weight",
          "Created At": "created_at",
          "Max Weight": 'max',
          "Min Weight": 'min',
        },
        json_meta: [
          [
            {
              key: "charset",
              value: "utf-8",
            },
          ],
        ],
        file_name: "former_data.csv",
        isLoadingTable: false, //Indicator does not show because table is not wrapped in v-app
    }),
    computed: {
    },
    watch: {

    },
    created() {
        //this.initialize();
    },
    methods: {
      onSelectCust(value) {
            this.disabled = false;
            this.cust_select = this.orders[value.customer_tbl_id];
        },
        onSelectMould(value) {
          this.isLoadingTable = true;
          console.log("loading");
          this.axios.get(this.route('former-data-table', value.order_tbl_id)).then((response) => {
            this.formers = response.data.former_data;
            this.file_name = response.data.order.customer.customer_id + "-" + response.data.order.mould_model.description + ".csv";
            this.isLoadingTable = false;
          }).catch(function (error) {
              console.log(error);
              this.isLoadingTable = false;
          })
      

        },
    }
};
</script>
