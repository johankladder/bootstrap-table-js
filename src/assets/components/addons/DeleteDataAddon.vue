<template>
    <div class="col-xs-6">
        <button v-on:click="onClick(computedModalId)" type="button" class="btn btn-link no-padding">
            <span class="glyphicon glyphicon-trash delete-icon" aria-hidden="true"></span>
        </button>
        <div v-if="params.confirmation" v-bind:id="computedModalId" class="modal fade" tabindex="-1" role="dialog"
             aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="confirmation-modal-title">
                            {{confirmationTitle}}
                        </h4>
                    </div>
                    <div class="modal-footer">
                        <div class="col-xs-6">
                            <button v-on:click="onConfirmationClick(computedModalId)" type="button"
                                    class="btn btn-success btn-block"
                                    id="modal-btn-yes">{{acceptText}}
                            </button>
                        </div>
                        <div class="col-xs-6">
                            <button v-on:click="onConfirmationDeclined(computedModalId)" type="button"
                                    class="btn btn-danger btn-block"
                                    id="modal-btn-no">{{declineText}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

    import ajax from '../helpers/ajaxhelper'

    export default {
        props: ['data', 'params'],

        computed: {
            computedModalId: function () {
                return this.modalId ? this.modalId : Math.floor(Math.random() * 10000 + 1);
            },
            acceptText: function () {
                if (this.params.confirmation.acceptText) {
                    return this.params.confirmation.acceptText;
                }
                return 'Yes';
            },
            declineText: function () {
                if (this.params.confirmation.declineText) {
                    return this.params.confirmation.declineText;
                }
                return 'No';
            },
            confirmationTitle: function () {
                if (this.params.confirmation.title) {
                    return this.params.confirmation.title;
                }
                return 'Confirmation'
            }
        },

        methods: {
            mounted: function () {
                $('.no-padding').closest('.parent-flex').css({
                    'float': 'right'
                })
            },
            onClick: function (modalId) {
                if (this.params.confirmation) {
                    $('#' + modalId).modal('show');
                } else {
                    this.onConfirmationClick();
                }
            },
            onConfirmationClick: function (modalId) {
                this.performDeleteAjaxCall();
                this.removeDataFromEntityArray(this.data);
                this.hideConfirmationModal(modalId);
            },
            removeDataFromEntityArray: function (data) {
                let index = this.$parent.entitiesarray.indexOf(data);
                this.$parent.entitiesarray.splice(index, 1);
            },
            performDeleteAjaxCall: function () {
                ajax.delete(
                    this.data['remove_url']
                );
            },
            onConfirmationDeclined: function (modalId) {
                this.hideConfirmationModal(modalId);
            },
            hideConfirmationModal: function (modalId) {
                $('#' + modalId).modal('hide');
            }
        }
    }
</script>
