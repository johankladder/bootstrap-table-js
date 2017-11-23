<template>
    <div class="">
        <button v-on:click="onClick" type="button" class="btn btn-link">
            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
        </button>
    </div>
</template>
<script>

    import ajax from '../helpers/ajaxhelper'

    export default {
        props: ['data', 'params'],

        methods: {
            onClick: function () {
                ajax.delete(
                    this.params.url,
                    this.data[this.params.identifier],
                );
                let index = this.$parent.entities.indexOf(this.data);
                this.$parent.entities.splice(index, 1)
            }
        }
    }
</script>
