
$( "#provincia" )
.change(function (evt) {
  var str = "";
  $('#ciudad option:eq(0)').prop('selected', true);
  // $('#ciudad').prop('disabled', true);
  $( "#provincia option:selected" ).each(function() {
    str = $( this ).val();
    console.log(str);
    if(str== 0){
      $('#ciudad option:eq(0)').prop('selected', true);
      // $('#ciudad').prop('disabled', true);
    }
    else{
    // console.log('en else... '+str)
    $("#form_provincia").val(str);
    str = "provincia="+str;
    evt.preventDefault();
    $.ajax({
           type: "POST",
           url: "/?/content/ciudades/",
           data: str, // serializes the form's elements.
           beforeSend : function (){
            },
           success: function(response)
           { // show response from the php script.
             $('#ciudad').html(response);
             // $('#ciudad').prop('disabled', false);
           },
           complete : function (){
            }
         });
    }
  });
});