<?php include("includes/init.php"); ?>

<?php if(!$session->is_signed_in() == '') {redirect("login.php");} ?>

<?php 
// if id is not there, redirect
if(empty($_GET['id'])) {
    redirect("users.php");
}
// get the user by id
$user = User::find_by_id($_GET['id']);

if ($user ) {
    $user->delete();
    redirect("users.php");
} else {
    redirect("users.php");
}

?>