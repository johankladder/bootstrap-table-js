<template>
    <div>
        <div class="image-data-addon" v-on:click="onClickModal(computedModalId)">
            <img v-if="data.data" class="image-data-view"
                 v-bind:src="html">
            <div class="middle">
                <span class="glyphicon glyphicon-search"></span>
            </div>
        </div>
        <div v-bind:id="computedModalId" v-if="data.data" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div v-html="data.data">

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['data', 'params'],

        computed: {
            computedModalId: function () {
                return this.modalId ? this.modalId : Math.floor(Math.random() * 10000 + 1);
            },
            html() {
                return require('../svgs/html-icon.png')
            }
        },

        methods: {
            onClickModal: function (modalId) {
                $('#' + modalId).modal('show');
            },
        },
    }

</script>
