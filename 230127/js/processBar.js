$(document).ready(function(){
    
    var clear_timer
    
    $('#csv_form').on('submit', function(event){
        // $('#message').html('')
        event.preventDefault()
        $.ajax({
            url: "../php/upload.php",
            type: "POST",
            data: new FormData(this),
            dataType:"json",
            contentType:false,
            cache:false,
            processData:false,
            beforeSend:function(){
                 $('#import').attr('disabled','disabled');
                 $('#import').val('진행 중 입니다.');
            },
            success:function(data) {
                if(data.success) {
                   //$('#csv_div').css('display', 'block');
                    start_import();
                    $('#total_data').text(data.total_line);
                    clear_timer = setInterval(get_import_data, 1000);
                    
                }
                if(data.error) {
                   // $('#message').html('<div class="alert alert-danger">'+data.error+'</div>');
                    $('#import').attr('disabled',false);
                    $('#import').val('Import');
                }
            }
        })
    })


    function start_import() {	    
     $('#process').css('display', 'none');
     $.ajax({
      url:"../php/write.php",
      success:function(){
      }
     })
    }

    function get_import_data() {
     $.ajax({
      url:"../php/process.php",
      success:function(data) {

       var total_data = $('#total_data').text();
       var width = Math.round((data/total_data)*100);
       $('#process_data').text(data);
       $('.progress-bar').css('width', width + '%');

       if(width >= 100) {
        clearInterval(clear_timer);
        // $('#process').css('display', 'none');
	$('#csv_div').css('display', 'block');
        $('#file').val('');
        // $('#message').html('<div class="alert alert-success">Data Successfully Imported</div>');
        $('#import').attr('disabled',false);
        $('#import').val('Import');

       }
      }
     })
    }
  
})
