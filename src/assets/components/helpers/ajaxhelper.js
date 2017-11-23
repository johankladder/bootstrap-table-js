import axios from 'axios';

export default {

    delete: function (url, value) {
        axios.delete(url, {
            identifier: value
        })
    }

}