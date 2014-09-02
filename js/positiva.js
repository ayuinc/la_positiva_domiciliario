
$( "#provincia" ).change(function (evt) {
  var str = "";
  $('#ciudad option:eq(0)').prop('selected', true);
  // $('#ciudad').prop('disabled', true);
  $( "#provincia option:selected" ).each(function() {
    str = $( this ).val();
    console.log(str);
    if(str== 0){
      // $('#ciudad option:eq(0)').prop('selected', true);
      $('#ciudad').prop('disabled', true);
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


$( "#distrito" ).change(function (evt) {
var str = "";
$( "#distrito option:selected" ).each(function() {
str = $( this ).val();
if(str=='DISTRITO'){
}
else{
str = str.replace(/-/gi," ");
str = "distrito="+str;
evt.preventDefault();
$.ajax({
       type: "POST",
       url: "/?/content/agencia/",
       data: str, // serializes the form's elements.
       success: function(response)
       { // show response from the php script.
         $('#result').html(response);
       }
     });
}
});
});

$( "#region" ).change(function (evt) {
  var str = "";
  $('#distrito option:eq(0)').prop('selected', true);
  $( "#region option:selected" ).each(function() {
    str = $( this ).val();
    if(str=='REGIÓN'){
      $('#distrito option:eq(0)').prop('selected', true);
    }
    else{
    str = str.replace(/-/gi," ");
    str = "region="+str;
    evt.preventDefault();
    $.ajax({
           type: "POST",
           url: "/?/content/distrito/",
           data: str, // serializes the form's elements.
           success: function(response)
           { // show response from the php script.
             $('#distrito').html(response);
             $('#distrito').prop('disabled', false);
             /*$('#loading').css('visibility', 'hidden');*/
           }
         });
    }
  });
});