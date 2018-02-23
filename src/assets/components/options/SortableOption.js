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
        sortable.on('sortable:sorted', (event) => {
            this.draggedModel = event.oldIndex;
            this.draggedOnModel = event.newIndex;
            this.performActionsAfterSort();
        });
    }

    extractEntityFromArrayWithIndex(index) {
        return this.vueInstance.entitiesarray[index];
    }

    performActionsAfterSort() {
        this.reOrderEntitiesArray();
        this.determineIfAjaxCallIsNecessary();
    }

    reOrderEntitiesArray() {

        Array.prototype.move = function (from, to) {
            this.splice(to, 0, this.splice(from, 1)[0]);
        };

        let tmp = this.vueInstance.entitiesarray.slice();

        tmp.move(this.draggedModel, this.draggedOnModel);

        this.vueInstance.entitiesarray = Object.assign(this.vueInstance.entitiesarray, tmp)
        
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
