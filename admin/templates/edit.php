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
         <span class="sr-only">Toggle navigation</span>
           <span class="icon-bar"></span>
           <span class="icon-bar"></span>
           <span class="icon-bar"></span>
         </button>
         <a class="navbar-brand" href="#"><?php echo $c->brand; ?></a>
      </div>

      <div class="collapse navbar-collapse" id="collapse">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="index.php">Dashboard</a></li>
          <li><a href="account.php">Account</a></li>
          <li><a href="create.php">Create</a></li>
          <li><a href="configs.php">Configs</a></li>
          <li><a href="logout.php">Logout</a></li>
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
    <h4>Edit quize</h4>
    <form action="actions/takeedit.php?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="file">Quiz backgound jpeg or jpg 600x300</label>
        <input type="file" name="upload" id="file">
        <p class="help-block"><input type="checkbox" name="update"> Change image </p>
        <p class="help-block">Curent image</p>
        <img src="<?php echo $c->path; ?>/storage/backgrounds/<?php echo $q->url; ?>" width="600px" height="300px">
        <input type="hidden" value="<?php echo $q->url; ?>" name="img">
      </div>
      <div class="form-group">
        <label for="title">Quiz title</label>
        <input type="text" name="title" class="form-control" id="title" value="<?php echo $q->title; ?>">
      </div>
      <div class="form-group">
        <label for="question">Quiz question (max 50 characters)</label>
        <input type="text" name="question" class="form-control" id="question" value="<?php echo $q->question; ?>">
      </div>
      <div class="form-group">
        <label for="answer">Quiz answer (Ex: here is my answer1 , here is my answer2 , etc)</label>
        <textarea class="form-control" name="answer" id="answer"><?php echo $q->answers; ?></textarea>
      </div>
      <button type="submit" class="btn btn-default">Update</button>
      <a href="actions/takedelete.php?id=<?php echo $_GET['id']; ?>" class="btn btn-danger">Delete</a>
    </form>
  </main>
  <br />
  <!-- jQuesry -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="../assets/js/bootstrap.min.js"></script>
</body>
</html>