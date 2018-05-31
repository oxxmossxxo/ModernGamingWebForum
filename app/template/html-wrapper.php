<html>
  <head>
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" /> 
    <?=$head?>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <title><?=$title?></title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container">
        <a class="navbar-brand" href="index.php">Modern Gaming Forum</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item active">
              <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php?controller=board">Discussion Boards</a>
            </li>
            <?php if ( $user && $user->id ): ?>
            <li class="nav-item">
              <a class="nav-link disabled" href="index.php?controller=login&action=logout">Logout <?=$user->username?></a>
            </li>
            <?php else: ?>
            <li class="nav-item">
              <a class="nav-link disabled" href="index.php?controller=login">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link disabled" href="index.php?controller=register">Sign up</a>
            </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container">
      <h1><?=$title?></h1>
      <?=$alert?>
      <?=$body?>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
