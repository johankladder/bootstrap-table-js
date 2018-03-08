<template>
    <tbody>
    <tr v-for="(entity, index) in entitiesarray" class="entity-data-row">
        <td class="default-data" v-for="data in parseEntityToCurrentHeaderFormat(entity)">
            <div v-for="addons in extractAddons(data)" class="parent-flex">
                <div v-for="addon in addons">
                    <div v-if="extractAddonKey(addon) === 'image'">
                        <image-data-addon
                                v-bind:data=data
                                v-bind:params=extractAddonParams(addon)
                        />
                    </div>
                    <div v-else-if="extractAddonKey(addon) === 'index'">
                        {{index}}
                    </div>
                    <div v-else-if="extractAddonKey(addon) === 'color'">
                        <color-data-addon
                                v-bind:data=data
                                v-bind:params=extractAddonParams(addon)
                        />
                    </div>
                    <div v-else-if="extractAddonKey(addon) === 'html'">
                        <html-data-addon
                                v-bind:data=data
                                v-bind:params=extractAddonParams(addon)
                        />
                    </div>
                    <div v-else-if="extractAddonKey(addon) === 'remove'">
                        <delete-data-addon
                                v-bind:data=entity
                                v-bind:params=extractAddonParams(addon)
                        />
                    </div>
                    <div v-else-if="extractAddonKey(addon) === 'update'">
                        <update-data-addon
                                v-bind:data=entity
                                v-bind:params=extractAddonParams(addon)
                        />
                    </div>
                    <div v-else>
                        <default-data-addon
                                v-bind:data=data
                        />
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
    import htmlDataAddon from './addons/HtmlDataAddon.vue'
    import colorDataAddon from './addons/ColorDataAddon.vue'
    import indexDataAddon from './addons/IndexDataAddon.vue'

    export default {
        props: ['headers', 'entitiesarray'],

        components: {
            'default-data-addon': defaultDataAddon,
            'image-data-addon': imageDataAddon,
            'delete-data-addon': deleteDataAddon,
            'update-data-addon': updateDataAddon,
            'html-data-addon': htmlDataAddon,
            'color-data-addon': colorDataAddon,
            'index-data-addon': indexDataAddon
        },

        methods: {

            parseEntityToCurrentHeaderFormat(entity) {
                let tableDataArray = [];
                $.each(this.headers, (index, header) => {
                    tableDataArray.push(
                        {
                            'data': this.extractDataFromEntityWithHeader(entity, header),
                            'header': header
                        }
                    );
                });
                return tableDataArray;
            },

            extractDataFromEntityWithHeader(entity, header) {
                return entity[header.key];
            },

            extractAddonKey(addon) {
                return addon ? addon.key : undefined;
            },

            extractAddonParams(addon) {
                return addon.params
            },

            extractAddons(data) {
                return data.header.addon ? data.header.addon : [['default']]
            }

        },

    }
</script>