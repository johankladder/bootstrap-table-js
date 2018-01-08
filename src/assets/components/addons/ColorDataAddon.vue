<template>
    <div class="default-data">
        <span class="badge badge-secondary" v-bind:style="{'background-color': data.data}">{{data.data}}</span>
    </div>
</template>
<script>
    export default {
        props: ['data']
    }
</script>
