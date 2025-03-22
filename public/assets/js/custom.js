$( function() {
    $( "#datepicker" ).datepicker();

    $(".sel2input").select2()   
    
    if(currentPage =='inventoryHistory'){
      let url = $("#inventoryHistoryWithPaginateUrl").val();
      $.ajax({
        url: url,  // The URL defined in your routes
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // CSRF Token
        },
        data: {
          perpage:10,
          pagenum:1
        },
        success: function(response) {     
          console.log(response);
          
        },
        error: function(xhr, status, error) {
        }
    });          
    }
  } );