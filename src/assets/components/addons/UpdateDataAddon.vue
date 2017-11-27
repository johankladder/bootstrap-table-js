<template>

    <div class="">
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
                document.location.href = this.params.url;
            }
        }
    }
</script>
