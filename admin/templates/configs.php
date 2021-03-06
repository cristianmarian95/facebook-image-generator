<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,400,600" rel="stylesheet">
    <link href="../assets/css/font-awesome.min.css" rel="stylesheet" >
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/app.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <title><?php echo $c->title . ' | AdminCP ';?></title>
  </head>
<body>
  <!-- Navigation -->
  <nav class="navbar navigation">
    <div class="container">
      <div class="navbar-header">
         <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse" aria-expanded="false">
          <i class="fa fa-bars" aria-hidden="true"></i>
         </button>
         <a class="navbar-brand" href="#"><?php echo $c->brand; ?></a>
      </div>

      <div class="collapse navbar-collapse" id="collapse">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="index.php"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>
          <li><a href="account.php"><i class="fa fa-user" aria-hidden="true"></i> Account</a></li>
          <li><a href="create.php"><i class="fa fa-pencil-square" aria-hidden="true"></i> Create</a></li>
          <li><a href="configs.php"><i class="fa fa-cogs" aria-hidden="true"></i> Configs</a></li>
          <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-code" aria-hidden="true"></i> Advertisements <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="adslist.php"><i class="fa fa-list-alt" aria-hidden="true"></i> Banners</a></li>
              <li><a href="ads.php"><i class="fa fa-plus-square" aria-hidden="true"></i> Add Banner</a></li>
              <li><a href="onclick.php"><i class="fa fa-chain-broken" aria-hidden="true"></i> OnClick AD</a>
            </ul>
          </li>
          <li><a href="logout.php"><i class="fa fa-power-off" aria-hidden="true"></i> Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <?php if($error) { ?>
  <div class="container">
    <div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong><?php echo $error; ?></strong>
    </div>
  </div>
  <?php } ?>

  <?php if($success) { ?>
  <div class="container">
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong><?php echo $success; ?></strong>
    </div>
  </div>
  <?php } ?>

  <!-- Main Content -->
  <main class="container main">
    <h4>Website Configs</h4>
    <form action="actions/takeupdate.php" method="post">
      <div class="form-group">
        <label for="title">Website title</label>
        <input type="text" name="title" class="form-control" id="title" value="<?php echo $c->title; ?>">
      </div>
      <div class="form-group">
        <label for="brand">Website brand</label>
        <input type="text" name="brand" class="form-control" id="brand" value="<?php echo $c->brand; ?>">
      </div>
      <div class="form-group">
        <label for="desc">Website description</label>
        <textarea name="desc" class="form-control" id="desc"><?php echo $c->description; ?></textarea>
      </div>
      <div class="form-group">
        <label for="keyw">Website keywords</label>
        <textarea name="keyw" class="form-control" id="keyw"><?php echo $c->keywords; ?></textarea>
      </div>
      <div class="form-group">
        <label for="path">Website path (Ex: http://exemple.com or http://exemple.com/folder)</label>
        <input type="url" name="path" class="form-control" id="path" value="<?php echo $c->path; ?>">
      </div>
      <div class="form-group">
        <label for="app-id">Facebook APP ID</label>
        <input type="text" name="app_id" class="form-control" id="app-ip" value="<?php echo $c->app_id; ?>">
      </div>
      <div class="form-group">
        <label for="app_secret">Facebook APP Secret</label>
        <input type="text" name="app_secret" class="form-control" id="app_secret" value="<?php echo $c->app_secret; ?>">
      </div>
      <div class="form-group">
        <label for="app_version">Facebook APP Version</label>
        <input type="text" name="app_version" class="form-control" id="app_version" value="<?php echo $c->app_version; ?>">
      </div>
      <button type="submit" class="btn btn-default">Update</button>
    </form>
  </main>
  <br />
  <!-- jQuesry -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="../assets/js/bootstrap.min.js"></script>
</body>
</html>