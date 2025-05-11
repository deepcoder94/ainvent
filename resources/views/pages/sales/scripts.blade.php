<script>
    function getSales(){
        let datepicker = $("#datepicker").val();
        let selectedBeat = $("#selectedBeat").val();

        $.ajax({
            url: "{{ route('sales.search') }}",  // The URL defined in your routes
            type: 'GET',
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // CSRF Token
            },
            data: { date:datepicker.length>0?datepicker:'all',selectedBeat:selectedBeat.length>0?selectedBeat:'all' },
            success: function(response) {     
                $("#salesbody").html(response)                    
            },
            error: function(xhr, status, error) {
                console.log(error);
                
            }
        });                        

    }
</script>