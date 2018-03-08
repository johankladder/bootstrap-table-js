<template>
    <thead>
    <tr>
        <th v-for="header in headers">
            {{ extractHeaderLabelFromHeader(header) }}
        </th>
    </tr>
    </thead>
</template>


<script>
    export default {
        props: {
            headers: {
                type: Array
            }
        },

        methods: {
            extractHeaderLabelFromHeader(header) {
                return header.label ? header.label : header.key
            }
        }
    }
</script>