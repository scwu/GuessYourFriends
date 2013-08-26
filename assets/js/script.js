$(document).ready(function() {
  if ($('#friends').length) {
    var guess = $('#guess_box').val();
    $.ajax({
      type : 'POST',
      url : 'friends',
      dataType : 'json',
      data: {
        'name' : guess
      },
      success : function(response){
        $('#friends').append('<img src="' + response.url + '"/>'); 
        $('#score').append('<h2>' + response.score + '</h2>');
      }
    });
      
  }
});
