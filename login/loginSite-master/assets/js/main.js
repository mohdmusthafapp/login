$('#login').submit(function() {
  event.preventDefault();
  var input = {
    username: $('#username').val(),
    password: $('#password').val(),
    grant_type: 'client_credntials'
  };
  $.post('https://mobile-sgroext-pd.allstate.com/auth/oauth/v2/token', input, function(data) {
    console.log(data);
  });
});
