import {Sortable} from '@shopify/draggable';
import axios from 'axios';

export class SortableOption {

    constructor(options, vueInstance) {
        this.options = options;
        this.vueInstance = vueInstance;
    }

    init(rootSelector, draggableSelector) {
        const sortable = new Sortable(document.querySelectorAll(rootSelector), {
            draggable: draggableSelector,
            delay: '200' // <- Delay for dragging
        });

        this.defineCallbacks(sortable);
    }

    defineCallbacks(sortable) {
        const self = this;
        sortable.on('sortable:sort', function (event) {
            self.draggedModel = event.currentIndex

        });

        sortable.on('sortable:stop', function (event) {
            self.draggedOnModel = event.newIndex;
            self.performActionsAfterSort();
        });
    }

    extractEntityFromArrayWithIndex(index) {
        return this.sortedEntityArray[index];
    }

    performActionsAfterSort() {
        this.reOrderEntitiesArray();
        this.determineIfAjaxCallIsNecessary();
    }

    reOrderEntitiesArray() {

        let draggedOnValue = this.vueInstance.entitiesarray[this.draggedOnModel];

        Vue.set(this.vueInstance.entitiesarray, this.draggedOnModel, this.vueInstance.entitiesarray[this.draggedModel])
        Vue.set(this.vueInstance.entitiesarray, this.draggedOnModel, draggedOnValue)

        this.vueInstance.entitiesarray.splice(this.vueInstance.entitiesarray.length)
    }

    determineIfAjaxCallIsNecessary() {
        if (this.options.url) {
            this.performAjaxCall(
                this.options.url,
            )
        }
    }

    performAjaxCall(url) {
        axios.post(url, {
            entityOne: this.extractEntityFromArrayWithIndex(this.draggedModel),
            entityTwo: this.extractEntityFromArrayWithIndex(this.draggedOnModel)
        })
            .then(function (response) {
            })
            .catch(function (error) {
                console.log(error)
            })
    }
}