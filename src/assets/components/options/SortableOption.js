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
        var array = Array.prototype.move = function (from, to) {
            this.splice(to, 0, this.splice(from, 1)[0]);
        };
        array = this.vueInstance.computedEntities;
        array.move(this.draggedModel, this.draggedOnModel);
        this.sortedEntityArray = array;
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