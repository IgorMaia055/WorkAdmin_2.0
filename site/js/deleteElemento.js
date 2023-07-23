function deleteElemento(id){
    $.ajax({
        url: "{{ url('delete_conta_paga/') }}",
        method: 'POST',
        data: {
            'id': id
        },
        success: function (data) {
            if(data == 'ok'){
                window.location.href="{{ url('home/') }}"
            }
        }
    })
}