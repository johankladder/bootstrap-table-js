<template>
    <div class="col-xs-6">
        <button v-on:click="onClick" class="btn btn-link no-padding">
            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
        </button>
    </div>
</template>
<script>

    export default {
        inherit: true,

        props: ['data', 'params'],

        mounted: function () {
          $('.no-padding').closest('.parent-flex').css({
              'float' : 'right'
          })
        },

        methods: {
            onClick: function () {
                document.location.href = this.data['update_url'];
            }
        }
    }
</script>
