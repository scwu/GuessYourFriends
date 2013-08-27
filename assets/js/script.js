$(document).ready(function() {
  if ($('#friends').length) {
    var guess = $('#guess_box').val();
    guess_word('');
    $('#guess_box').keypress(function(e) {
      if (e.which == 13) {
        $('#friends').empty();
        $('#score').empty();
        var guess = $('#guess_box').val();
        $('#guess_box').val('');
        guess_word(guess);
        return false;
      }
    });
    function guess_word(guess) {
      $.ajax({
        type : 'POST',
        url : 'game/friends',
        dataType : 'json',
        data: {
          'name' : guess
        },
        success : function(response){
          console.log(guess);
          $('#friends').append('<img src="' + response.url + '"/>'); 
          $('#score').append('<h2>' + response.score + '</h2>');
        }
      });
    }
      
  }
});
