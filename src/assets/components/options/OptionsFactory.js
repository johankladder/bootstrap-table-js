import {SortableOption} from './SortableOption';

export default {

    defineOptions: function (options, vueInstance) {
        if (options.draggable) {
            this.defineDraggableOption(options, vueInstance);
        }
    },

    defineDraggableOption: function (options, vueInstance) {
        new SortableOption(
            options.draggable,
            vueInstance).init(
            'tbody', 'tr'
        )
    },

}

