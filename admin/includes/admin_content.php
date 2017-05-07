<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Admin
                <small>Subheading</small>
            </h1>
            
            <?php 
            
            
            // $user = new User();

            // $user->username = "Adam the User";
            // $user->password = "password";
            // $user->first_name = "Adam";
            // $user->last_name = "the User";
            // $user->create();

            // much cleaner than up top...
            $user = User::find_user_by_id(3);
            $user->last_name = "LOPEZ";
            $user->update();


            ?>


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