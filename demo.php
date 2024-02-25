<?php
include_once 'config/Database.php';
include_once 'class/User.php';
$database=new Database();
$db=$database->getConnection();

$user=new User($db);
if(!$user->loggedIn()){
    header("Location: index.php");
}
include('inc/header4.php')
?>
<title>This is demo php</title>
<body>
    <?php include('top_menus.php');?>
    <table id="tasksListing" class="table table-bordered table-striped">
			<thead>
				<tr>						
					<th>Id</th>					
					<th>Name</th>					
					<th>Class</th>
					<th>Usn</th>
					<th></th>
					<th></th>
										
				</tr>
			</thead>
		</table>
	</div>
	
    
</body>