<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,400,600" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/app.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <title><?php echo $c->title . ' | Home page';?></title>
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
    <div class="row">
      <!-- Left side -->
      <div class="col-lg-9 col-md-8 col-sm-8">
        <?php if(count($q) == 0) { ?> 
          <div class="alert alert-info" role="alert" style="width: 80%; margin:auto;">No quizes found.</div>
        <?php } ?>
        <div class="row"> 
          <?php if($q) { foreach ($q as $q) { ?>
          <div class="col-lg-6 col-md-12 col-sm-12">
            <a href="oauth.php?id=<?php echo $q->id; ?>">
              <div class="panel panel-default">
                <div class="panel-heading"><?php echo $q->title; ?></div>
                <div class="panel-body">
                  <img src="storage/backgrounds/<?php echo $q->url; ?>" width="100%">
                </div>
              </div>
            </a>
          </div>
          <?php } } ?>
        </div>
      </div>
      <!-- Right side -->
      <div class="col-lg-3 col-md-4 col-sm-4">
          <div class="row">
            <div class="col-xs-12">
              Ad Space
            </div>
            <div class="col-xs-12">
              Ad Space
            </div>
            <div class="col-xs-12">
              Ad Space
            </div>
          </div>
      </div>
    </div>
  </main>
  <!-- jQuesry -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>