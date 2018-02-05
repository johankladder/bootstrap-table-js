<template>
    <div>
        <table class="table">
            <vue-table-header v-bind:headers="computedHeaders">
            </vue-table-header>
            <vue-table-data
                    v-bind:entitiesarray="entitiesarray"
                    v-bind:headers="computedHeaders"
                    v-bind:options="computedOptions"
            >
            </vue-table-data>
        </table>
    </div>
</template>


<script>

    import header from './VueTableHeader.vue'
    import tableData from './VueTableData.vue'
    import optionsFactory from './options/OptionsFactory'

    export default {

        props: ['headers', 'entities', 'options'],

        components: {
            'vue-table-header': header,
            'vue-table-data': tableData
        },

        data: function () {
            return {
                'entitiesarray': {},
                'EntityData': JSON.parse(this.entities),
            }
        },

        computed: {
            computedHeaders: function () {
                return JSON.parse(this.headers);
            },
            computedEntities: function () {
                return JSON.parse(this.entities);
            },
            computedOptions: function () {
                return JSON.parse(this.options);
            }
        },

        mounted() {
            optionsFactory.defineOptions(this.computedOptions,
                this);
            this.entitiesarray = JSON.parse(this.entities);
        }

    }
</script>