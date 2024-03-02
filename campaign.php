<?php

include_once 'config/Database.php';
include_once 'class/User.php'; 
include_once 'class/Campaign.php'; 

$database = new Database();
$db = $database->getConnection();

$user = new User($db); 
$campaign = new Campaigns($db); 

if(!$user->loggedIn()) {
    header("Location: index.php");
    exit; 
}




  include('inc/header4.php');
  
?>

<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Delete campaign
    if (isset($_POST['campaign_id'])) {
        $campaign_id = $_POST['campaign_id'];
        if ($campaign->deleteCampaign($campaign_id)) {
            // Campaign deleted successfully
        } else {
            // Error deleting campaign
        }
    } 
    // Add campaign
    elseif (isset($_POST['submit_campaign'])) {
        $name = $_POST['name'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $description = $_POST['description'];
        $status = $_POST['status'];
        $social_media = $_POST['social_media'];
        $admin_id = $user->getLoggedInUserId();
        if ($campaign->insertCampaign($name, $start_date, $end_date, $description, $status, $social_media,$admin_id)) {
            // Campaign added successfully
        } else {
            // Error adding campaign
        }
    } 
    // Update campaign
    elseif (isset($_POST['update_campaign'])) {
        
            $campaign_id = $_POST['update_campaign_id'];
            $name = $_POST['name'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            $description = $_POST['description'];
            $status = $_POST['status'];
            $social_media = $_POST['social_media'];
        
            // Update the campaign
            if ($campaign->updateCampaign($campaign_id, $name, $start_date, $end_date, $description, $status, $social_media)) {
                // Campaign updated successfully
            } else {
                // Error updating campaign
            
        }
        
    }
}
    ?>





<title>CRM System</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<body>
    <?php include('top_menus.php'); ?>
    <div class="row row-offcanvas row-offcanvas-left">
        <?php include('left_menus.php'); ?>
        <div class="col-md-9 col-lg-10 main"> 
            <h2>Campaigns</h2> 
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-10">
                        <h3 class="panel-title"></h3>
                    </div>
                    <div class="col-md-2" align="right">
                        <button type="button" id="addCampaign" class="btn btn-info" title="Add Campaign"><span class="glyphicon glyphicon-plus">Add Campaign</span></button>
                    </div>
                </div>
            </div>
            
            <form method="post" id="campaignForm">
    <table id="campaignsListing" class="table table-bordered table-striped">
        <thead>
            <tr>                        
                <th>Id</th>                    
                <th>Name</th>                    
                <th>Start Date</th>
                <th>End Date</th>
                <th>Description</th>
                <th>Status</th>                    
                <th>Social Media</th>                      
                <th></th>    
                <th></th>                       
            </tr>
        </thead>
        <tbody>
            <?php
            $campaigns = $campaign->listCampaigns();
            foreach ($campaigns as $campaign) {
                echo "<tr>";
                echo "<td>{$campaign['id']}</td>";
                echo "<td>{$campaign['name']}</td>";
                echo "<td>{$campaign['start_date']}</td>";
                echo "<td>{$campaign['end_date']}</td>";
                echo "<td>{$campaign['description']}</td>";
                echo "<td>{$campaign['status']}</td>";
                echo "<td>{$campaign['social_media']}</td>";
                echo "<td><button type='submit' class='btn btn-sm btn-info edit-campaign' data-id='{$campaign['id']}'>Edit</button></td>";
                echo "<td><button type='submit' class='btn btn-sm btn-danger delete-campaign' name='campaign_id' value='{$campaign['id']}'>Delete</button></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</form>
<h2>Add Campaign</h2>
<form method="post">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="form-group">
                    <label for="start_date">Start Date:</label>
                    <input type="date" class="form-control" id="start_date" name="start_date">
                </div>
                <div class="form-group">
                    <label for="end_date">End Date:</label>
                    <input type="date" class="form-control" id="end_date" name="end_date">
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>
                <div class="form-group">
    <label for="status">Status:</label>
    <select class="form-control" id="status" name="status">
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
    </select>
</div>

                <div class="form-group">
                    <label for="social_media">Social Media:</label>
                    <input type="text" class="form-control" id="social_media" name="social_media">
                </div>
                <button type="submit" class="btn btn-primary" name="submit_campaign">Submit</button>
            </form>
            <h2>Update Campaign</h2>
            <form method="post">
         
                <div class="form-group">
        <label for="update_campaign_id">ID:</label>
        <input type="text" class="form-control" id="update_campaign_id" name="update_campaign_id">
    </div>
            <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="form-group">
                    <label for="start_date">Start Date:</label>
                    <input type="date" class="form-control" id="start_date" name="start_date">
                </div>
                <div class="form-group">
                    <label for="end_date">End Date:</label>
                    <input type="date" class="form-control" id="end_date" name="end_date">
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>
               
                 <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>

                <div class="form-group">
                    <label for="social_media">Social Media:</label>
                    <input type="text" class="form-control" id="social_media" name="social_media">
                </div>
                <button type="submit" class="btn btn-primary" name="update_campaign">Submit</button>
            </form>   
               
        </div>
        <div id="campaignModal" class="modal fade">
            <div class="modal-dialog">
                <form method="post" action="process_campaign.php" id="campaignForm">
                    
                    <div class="modal-content">
                        <!-- Form content here -->
                    </div>
                </form>
            </div>
        </div>
    </div>
   
</body>

</html>
