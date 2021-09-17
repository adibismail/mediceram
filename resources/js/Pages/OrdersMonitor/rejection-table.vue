<template>
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Rejection Table</h4>

                    <div class="row" style="margin: 8px; padding-left: 15px; align-items: center; flex-grow: 4;">
                        <span hidden style="padding-right: 15px">Select Mould: </span>
                        <v-select-graph hidden label="epc_title" @input="onSelectMould" 
                            :options="this.mould_options" :clearable="false" :loading="loading">
                                <template #spinner="{ loading }">
                                <div
                                    v-if="loading"
                                    style="border-left-color: rgba(88, 151, 251, 0.71)"
                                    class="vs__spinner"
                                >
                                    The .vs__spinner class will hide the text for me.
                                </div>
                            </template>
                        </v-select-graph>
                        <span style="color: white;">{{ label }}: </span>
                        <v-col cols="12" sm="6" md="1">
                            <v-text-field
                                :label="label"
                                v-model="numberValue"
                                :rules ="[rules.max, rules.min]"
                                single-line
                                type="number"
                                dark
                            />
                        </v-col>
                        <v-col cols="12" sm="6" md="2">
                            <v-checkbox
                                v-model="isConsecutive"
                                label="Consecutive"
                                dark
                            ></v-checkbox>
                        </v-col>
                        <v-col cols="12" sm="6" md="3">
                            <v-menu
                            ref="menu"
                            v-model="menu"
                            :close-on-content-click="false"
                            :return-value.sync="dates"
                            transition="scale-transition"
                            min-width="auto"
                            >
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                v-model="dateRangeText"
                                prepend-icon="mdi-calendar"
                                readonly
                                v-bind="attrs"
                                v-on="on"
                                dark
                                ></v-text-field>
                            </template>
                            <v-date-picker
                                v-model="dates"
                                no-title
                                scrollable
                                dark
                                range
                            >
                            <v-spacer></v-spacer>
                                <v-btn
                                text color="primary"
                                @click="menu = false"
                                >
                                Cancel
                                </v-btn>
                                <v-btn
                                text color="primary"
                                @click="saveDate"
                                >
                                OK
                                </v-btn>
                            </v-date-picker>
                            </v-menu>
                        </v-col>
                        <v-btn class="btn btn-success btn-fw" @click="search">
                            Search
                        </v-btn>
                    </div>

                    <!-- items= {DATA} -->
                    <v-data-table dark
                        height="43vh"
                        :headers="headers"
                        :items="rejected_moulds"
                        :items-per-page="5"
                        :loading="isLoadingTable"
                        class="elevation-1 table-bg"
                    ></v-data-table>
                </div>
            </div>
        </div>
    </div>
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

    .v-input {
        font-size: 0.9em;
    }

</style>

<script>
import Layout from "@/Shared/Layout";

export default {
    //metaInfo: { title: "Rejection Table" },
    layout: Layout,
    props: ["moulds"],
    mounted() {
        this.mould_options = this.moulds;
        var d = new Date();
        d.setMonth(d.getMonth() - 6);
        this.dates = [d.toISOString().substr(0, 10), new Date().toISOString().substr(0, 10)];
    },
    data: () => ({
        mould_options: [],
        mould_select: [],
        disabled: true,
        headers: [
            {
            text: 'EPC',
            align: 'start',
            sortable: false,
            value: 'epc.epc',
            },
            { text: 'Mould Type', value: 'model.description' },
            { text: 'Plaster Moulding Station', value: 'epc.pms.plaster_moulding_station_id' },
            { text: 'Worker ID', value: 'worker.worker_id'},
            { text: 'Rejection Ratio', value: 'rejection_ratio' },
            { text: 'Consecutive Failures', value: 'consecutive' },
            { text: 'Most Recent Former', value: 'latest_former' },
        ],
        rejected_moulds: [
        ],
        numberValue: 0,
        rules: {
            min: value => value >= 0 || 'Number should not be below 0',
            max: value => value <= 100 || 'Number should not be above 100',
        },
        dates: [new Date().toISOString().substr(0, 10), new Date().toISOString().substr(0, 10)],
        menu: false,
        isConsecutive: true,
        loading: false,
        isLoadingTable: false,
    }),
    computed: {
        dateRangeText () {
            return this.dates.join(' ~ ')
        },
        label (){
            if (this.isConsecutive)
                return "Consecutive Failures";
            else    
                return "Rejection Ratio";
        }
    },
    watch: {

    },
    created() {
        //this.initialize();
    },
    methods: {
        onSelectMould(value) {
            this.disabled = false;
            this.mould_select = value.plaster_mould_tbl_id;
            this.axios.get(this.route('formers-for-mould', 
                {numberValue: this.numberValue,
                mould: this.mould_select,
                isConsecutive: this.isConsecutive,
            })).then((response) => {
                console.log(response);

            }).catch(function (error) {
                console.log(error);
            })
        },
        search(){
            this.loading = false;
            this.isLoadingTable = true;
            console.log('loading')
            this.axios.get(this.route('moulds-for-failure_rate',
                {dates: this.dates,
                numberValue: this.numberValue,
                mould: this.mould_select,
                isConsecutive: this.isConsecutive,
            })).then((response) => {
                this.rejected_moulds = response.data.moulds;
                this.isLoadingTable = false;
            }).catch(function (error) {
                console.log(error);
                this.isLoadingTable = false;
            })
         
        },

        saveDate(){
            this.$refs.menu.save(this.dates)
            // this.loading = true;
            // this.axios.get(this.route('moulds-for-date', 
            //     {dates: this.dates, 
            // })).then((response) => {
            //     console.log(response);
            //     this.mould_options = response.data.moulds;
            // }).catch(function (error) {
            //     console.log(error);
            // })
            // this.loading = false;
        }
    }
};
</script>
