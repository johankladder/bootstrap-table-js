

export default {

    delete: function (url, value) {
        $.ajax(url, {
            type: 'DELETE',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            error: function (error) {
                console.log(error);
            }
        })
    }

}