
$(function(){
  $('#cotizar').bootstrapValidator();
  $('.registro').bootstrapValidator();
  $('.buscar').bootstrapValidator();
  $('#ciudad').prop('disabled', true);
  $( "#distrito" ).prop('disabled', true);
  $( ".result" ).hide();
  // $('#version').prop('disabled', true);
  // $('#ano').prop('disabled', true);
  $('.price-block label').click(function(){
    $('.price-block label').removeClass('checked');
    $(this).addClass('checked');
  });

  $('#phone').click(function(){
    $('.buscar').hide();
  });
  $('#download').click(function(){
    $('.buscar').show();
  });

});

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
              $('#ciudad').prop('disabled', false);
             },
             complete : function (){
              }
      });
    }
  });
});

$( "#ciudad" ).change(function (evt) {
  var str = "";
  var url = "";
  // $('#ciudad option:eq(0)').prop('selected', true);
  // $('#ciudad').prop('disabled', true);
  $( "#ciudad option:selected" ).each(function() {
    // str = $( this ).text();
    // $("#form_ano").val(str);
    // option = $( this ).val();
    // option = option.replace(/,/gi,"");
    option = $('#valor_vivienda').val();
    console.log(option);
    if(option == 7){
      url = "/?/content/taza";
    }else{
      url = "/?/content/hogar_positivo";
    }
    $('#cotizar').attr('action', url); //this fails silently
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
          $('.result').show();
          $('.result').html(response);
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

$('#singlebutton').click(function (evt) {
    var val_robo = $('input:radio[name=robo]:checked').val();
    $('#id_seguro').prop('value' , val_robo)
});