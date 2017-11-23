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
                if (header.label) {
                    return header.label;
                }
                return header.key
            }
        }
    }
</script>