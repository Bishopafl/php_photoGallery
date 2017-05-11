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

            // $user->username = "superman";
            // $user->password = "lois";
            // $user->first_name = "clark";
            // $user->last_name = "kent";
            
            // $user->create();
            
            
            // Examples below are much, much cleaner than up top... 
            // Just testing the different ways to do things :)

             /* update function example */
            // $user = User::find_user_by_id(8);
            // $user->username = "Boogie man";
            // $user->password = "bugs";
            // $user->first_name = "oogie";
            // $user->last_name = "boogie";
            // $user->update();
            

            /* delete function example */
            // $user = User::find_user_by_id(2);
            // $user->delete();
            
            

            /* start's the save function testing */
            // $user = User::find_user_by_id(6);
            // $user->password = "bamp";
            // $user->save();
            
            

            /* save function example */
            // $user = new User();
            // $user->username = "Bojangles";
            // $user->save();

            /* finds all users by username in database */
            // $user = array();
            // $users = User::find_all();

            // foreach ($users as $user) {
            //     echo $user->username;
            // }   
        //  --------------------------------------------------
            /* finds all photos by title in database */
            // $photos = array();
            // $photos = Photo::find_all();

            // foreach ($photos as $photo) {
            //     echo $photo->title;
            // }

            // $photo = new Photo();

            // $photo->title = "the dubs";
            // $photo->size = 20;
            
            // $photo->create(); 
            
            echo INCLUDES_PATH;

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