<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,400,600" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet" >
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/app.css" rel="stylesheet">
    <?php if(isset($_COOKIE['token'])) { ?>
    <meta property="og:url" content="<?php echo $c->path; ?>/share.php?token=<?php echo $_COOKIE['token']; ?>">
    <?php } ?>
	  <meta property="og:type" content="article" >
	  <meta property="og:title" content="<?php echo $c->title; ?>" >
	  <meta property="og:description" content="<?php echo $q->title; ?>" >
	  <meta property="og:description" content="<?php echo $q->title; ?>" >
    <meta property="og:image" content="<?php echo $i->image; ?>" >
    <meta property="og:image:type" content="image/png" />
    <meta property="og:image:width" content="600" />
    <meta property="og:image:height" content="315" />
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <title><?php echo $c->title . ' | ' . $c->title;?></title>
  </head>
<body>
  <!-- Navigation -->
  <nav class="navbar navigation">
    <div class="container">
      <div class="navbar-header">
         <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse" aria-expanded="false">
         <span class="sr-only">Toggle navigation</span>
           <span class="icon-bar"></span>
           <span class="icon-bar"></span>
           <span class="icon-bar"></span>
         </button>
         <a class="navbar-brand" href="#"><?php echo $c->brand; ?></a>
      </div>

      <div class="collapse navbar-collapse" id="collapse">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="index.php">Home</a></li>
          <li><a href="contact.php">Contact</a></li>
          <li><a href="faq.php">FAQ</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="container main">
    <center><h1><?php echo $q->title; ?></h1></center>
    <br />
    <center>
      <a href="<?php echo htmlspecialchars($loginUrl); ?>" class="btn btn-primary">
        <i class="fa fa-facebook" aria-hidden="true"></i> Log in with Facebook!
      </a>
    </center>
    <br />
  </main>

  <!-- jQuesry -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>