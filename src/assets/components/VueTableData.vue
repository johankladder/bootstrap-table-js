<template>
    <tbody>
    <tr v-for="entity in entities" class="entity-data-row">
        <td v-for="data in parseEntityToCurrentHeaderFormat(entity)">
            <div v-for="addons in extractAddons(data)" class="parent-flex">
                <div v-for="addon in addons">
                    <div v-if="extractAddonKey(addon) === 'image'">
                        <image-data-addon
                                v-bind:data=data
                                v-bind:params=extractAddonParams(addon)
                        ></image-data-addon>
                    </div>
                    <div v-else-if="extractAddonKey(addon) === 'remove'">
                        <delete-data-addon
                                v-bind:data=entity
                                v-bind:params=extractAddonParams(addon)
                        ></delete-data-addon>
                    </div>
                    <div v-else-if="extractAddonKey(addon) === 'update'">
                        <update-data-addon
                                v-bind:data=entity
                                v-bind:params=extractAddonParams(addon)
                        ></update-data-addon>
                    </div>
                    <div v-else>
                        <default-data-addon
                                v-bind:data=data
                        ></default-data-addon>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    </tbody>
</template>

<script>

    import defaultDataAddon from './addons/DefaultDataAddon.vue'
    import imageDataAddon from './addons/ImageDataAddon.vue'
    import deleteDataAddon from './addons/DeleteDataAddon.vue'
    import updateDataAddon from './addons/UpdateDataAddon.vue'

    export default {
        props: {
            entities: {
                type: Array
            },
            headers: {
                type: Array
            }
        },

        components: {
            'default-data-addon': defaultDataAddon,
            'image-data-addon': imageDataAddon,
            'delete-data-addon': deleteDataAddon,
            'update-data-addon': updateDataAddon,
        },

        methods: {

            parseEntityToCurrentHeaderFormat(entity) {
                const dataArr = [];
                for (let index = 0; index < this.headers.length; index++) {
                    const header = this.headers[index];
                    const tempData = [];
                    tempData['data'] = this.extractDataFromEntityWithHeader(
                        entity, header
                    );
                    tempData['header'] = header;
                    dataArr.push(tempData);
                }
                return dataArr;
            },

            extractDataFromEntityWithHeader(entity, header) {
                return entity[header.key];
            },

            extractAddonKey(addon) {
                if (addon) {
                    return addon.key
                }
                return undefined;
            },

            extractAddonParams(addon) {
                return addon.params
            },

            extractAddons(data) {
                if (data.header.addon) {
                    return data.header.addon;
                }
                return [
                    [
                        'default'
                    ]
                ]
            }

        },

    }
</script>