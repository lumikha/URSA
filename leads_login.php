<!DOCTYPE html>
<?php
  session_start();
  if(@$_SESSION['logged'] == true){
    header("Location: leads.php");
  }
?> 
<?php 
  if(@$_POST['login']){
    if(isset($_POST['username']) && isset($_POST['password'])){
        if($_POST['username'] == "" && $_POST['password'] ==""){
          $_SESSION['logged'] = true;
          header("Location: leads.php");
        }else{
         ?>
          <div class="alert alert-warning fade in">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Warning !</strong> Invalid Login Credentials. Please Try again.
            </div>
         <?php
        }
      }
  }
?>
<html lang="en">
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="js/dataTables/dataTables.bootstrap.min.css">
	</head>
	<body>

<div class="container marketing">
  <hr class="featurette-divider">
    <div class="container">
      <div class="row">
    <div class="col-md-4 col-md-offset-4 text-left" style="background-color:#F8F8F8;">
      <center>
        <br>
        <div class='panel panel-success'>
       <div class='panel-heading text-center'><h4><strong><span class="glyphicon glyphicon-user" aria-hidden="true"</strong><h4></div>
      </div>
      <form method="POST">
        <input type="text" class="form-control input-sm" name="username" placeholder="Username" required><br>
        <input type="password" class="form-control input-sm" name="password" placeholder="Password" required><br>
        <input type="submit" class="btn btn-primary" name="login" value="Login"><br><br>

  </form> 
  <br>
</div>
    </div>
</div>
    </div> <!-- /container -->

	</body>

</html>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="js/dataTables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script src="js/dataTables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="js/angular.min.js"></script>