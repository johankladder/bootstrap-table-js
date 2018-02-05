<template>

    <div class="col-xs-6">
        <button v-on:click="onClick" class="btn btn-link">
            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
        </button>
    </div>

</template>
<script>

    export default {
        inherit: true,

        props: ['data', 'params'],

        methods: {
            onClick: function () {
                document.location.href = this.data['update_url'];
            }
        }
    }
</script>
