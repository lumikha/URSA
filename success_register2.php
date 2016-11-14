<?php
	if(isset($_GET['e']) && isset($_GET['p'])) {
		$email = $_GET['e'];
		$pass = $_GET['p'];
	}
?>
<html>
<head>
	<title>Enroll Customer</title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
  <link rel="stylesheet" type="text/css" href="js/dataTables/dataTables.bootstrap.min.css"/>
  <link rel="Shortcut icon" href="img/ursa_tab_logo.png"/>
  <style>
  	#success_information a{
  		text-decoration: none;
  	}
  </style>
</head>
<body>

<style type="text/css">

html, body 
{ 
  /*background-image: url("img/little_dipper.jpg");*/
  background: #EEEEEE;
  color: #ffb30f;

}
html, body 
{ 
  /*background-image: url("img/little_dipper.jpg");*/
  background: #052F6D;

}


.regbutton
{
  background-color: #052F6D !important;
  color: #FFF;

}
.regbutton
{
  background: -webkit-linear-gradient(#ffb30f, #ffae00);
  background: -moz-linear-gradient(#ffb30f, #ffae00);
  background: -o-linear-gradient(#ffb30f, #ffae00);
  color: #FFFFFF;
  margin-left: 1em;
  
}

.regbutton:hover
{
  background-color: #FFF !important;
  color: #052F6D;

}

h1
{
  color: #FFF;
}



</style>



        <div class="container_12 logotitle" style="margin-top:60px; ">                          
            <div class="grid_4 push_3 logo text-center">
                <a id="home" class="disp_tickets" href="#"> 
                    <img src="img/ursa3.png" height="160" align="middle" >
                </a>
            </div> 
        </div>

            <div class="container_12 logotitle">
              
              <div class="grid_4 push_3 pagetitle">
                 <!--content here, for layout purposes-->
              </div>             
            
        </div>

<div id="success_information" class="row">
	<div class="col-md-offset-3 col-md-6" style="text-align: center;">
    	<div class="panel-b1dy" id="demo">
      		<h1>Success!</h2><br/>
      		<h3>You have successfully enrolled a new customer. </h3> <br> <br>
      		
      	       <div class="grid_2 push_4">
                <input type="submit" class="btn btn-primary regbutton" name="" onclick="redirect()" value="Enroll New Customer">
               </div>
      		    	</div>
  	</div>
</div>
</body>
</html>

<script>
  function redirect() {
    window.location = "register2";
  }
</script>