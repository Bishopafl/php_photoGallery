<?php include("includes/header.php"); ?>
<<<<<<< HEAD
	<!-- Navigation -->
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	   <!-- Brand and toggle get grouped for better mobile display -->
	   
	   <?php include("includes/top_nav.php") ?>

	   <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
	       <?php include("includes/side_nav.php") ?>
	   <!-- /.navbar-collapse -->
	</nav>
	<div id="page-wrapper">
		<div class="container-fluid">

		    <!-- Page Heading -->
		    <div class="row">
		        <div class="col-lg-12">
		            <h1 class="page-header">
		                Upload
		                <small>Subheading</small>
		            </h1>
		            <ol class="breadcrumb">
		                <li>
		                    <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
		                </li>
		                <li class="active">
		                    <i class="fa fa-file"></i> Blank Page
		                </li>
		            </ol>
		        </div>
		    </div>
		    <!-- /.row -->

		</div>
		<!-- /.container-fluid -->
	   

	</div>
	<!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>
=======

<?php if(!$session->is_signed_in() == '') {redirect("login.php");} ?>

<?php 
	$message = "";
	if (isset($_POST['submit'])) {
		
		$photo = new Photo();
		$photo->title = $_POST['title'];
		$photo->set_file($_POST['file_upload']);

		// let's check if the photo saved and display a message!
		if($photo->save()) {

			$message = "Photo uploaded successfully";
		
		} else {
			// if photo didn't save, output a message from the errors array
			$message = join("<br>", $photo->errors);

		}

	}

?>


<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
   <!-- Brand and toggle get grouped for better mobile display -->
   
   <?php include("includes/top_nav.php") ?>

   <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
       <?php include("includes/side_nav.php") ?>
   <!-- /.navbar-collapse -->
</nav>

<div id="page-wrapper">
	<div class="container-fluid">
	<!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Upload
                <small>Subheading</small>
            </h1>
				<!-- form starts here -->
				<div class="col-md-6">
					<?php echo $message;?>
					<form action="upload.php" method="post" enctype="multipart/form-data">
					
						<div class="form-group">
							<input type="text" name="title" class="form-control">
						</div>
					
						<div class="form-group">
							<input type="file" name="file_upload">
						</div>

						<div>
							<input type="submit" name="submit">
						</div>
					</form>
				</div> <!-- /.col-md-6 -->
    		</div> <!-- /.col-lg-12 -->
 		</div> <!-- /.row -->
	</div> <!-- /.container-fluid -->
</div><!-- /#page-wrapper -->

<?php include("includes/footer.php"); ?>
>>>>>>> 7164d87f6fe46b6c9079a9cf73fb5f27a660cb22
