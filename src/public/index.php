<!DOCTYPE HTML>
<html>
  <head>
    <title>TA Replacements Web App</title>

    <!-- ==========================
     Meta Tags
    =========================== -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ==========================
     CSS
    =========================== -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="./styles/style.css" rel="stylesheet" type="text/css">

    <!-- ==========================
    JS
    =========================== -->

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script async src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script async src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script type="text/javascript" src="http://cdn.rawgit.com/h2non/jsHashes/master/hashes.js"></script>

  </head>
  <body>
    <form id='login' method='post' action='register.php'>
      <div class="card">
        <h4 class="card-header">Sign In</h4>
        <div class="card-block">
          <label><div>Email</div>
            <input required type="email" name="email">
          </label>
          <label><div>Password</div>
         <input required type="password" name="password">
          </label>
         <button class='btn' type='submit'>Sign In</button>
        </div>
        <hr style="margin: 0">
        <div class='link'>Create account</div>
      </div>
    </form>
  </body>
</html>
