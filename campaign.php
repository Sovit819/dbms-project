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
        $start_date = date('Y-m-d');
        $end_date = $_POST['end_date'];
        $description = $_POST['description'];
        $status = "Active";
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
            $start_date = date('Y-m-d');
            $end_date = $_POST['end_date'];
            $description = $_POST['description'];
            $status = "Active";
            $social_media = $_POST['social_media'];
            // echo " $social_media this is social media<br>";
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
                    <div class="col-md-1">
                        <button type="button" id="addCampaign" class="btn btn-info" title="Add Campaign" data-toggle="modal" data-target="#addCampaignModal"><span class="glyphicon glyphicon-plus"></span> Add Campaign</button>
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
                // echo "<td><button type='button' class='btn btn-sm btn-info edit-campaign' data-toggle='modal' data-target='#updateCampaignModal' data-id='{$campaign['id']}'>Edit</button></td>";
                echo "<td><button type='button' class='btn btn-sm btn-info edit-campaign' data-toggle='modal' data-target='#updateCampaignModal' data-id='{$campaign['id']}' data-name='{$campaign['name']}' data-end-date='{$campaign['end_date']}' data-description='{$campaign['description']}' data-social-media='{$campaign['social_media']}'>Edit</button></td>";

                echo "<td><button type='submit' class='btn btn-sm btn-danger delete-campaign' name='campaign_id' value='{$campaign['id']}'>Delete</button></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</form>

           

<div class="modal fade" id="addCampaignModal" tabindex="-1" aria-labelledby="addCampaignModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCampaignModalLabel">Add New Campaign</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post">
          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name">
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
                    <input type="text" class="form-control" id="status" name="status" readonly value="Active">
                </div>
          <div class="form-group">
            <label for="social_media">Social Media:</label>
            <input type="text" class="form-control" id="social_media" name="social_media">
          </div>
          <button type="submit" class="btn btn-primary" name="submit_campaign">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="updateCampaignModal" tabindex="-1" aria-labelledby="updateCampaignModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateCampaignModalLabel">Update Campaign</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="updateCampaignForm">
          <div class="form-group">
            <label for="update_campaign_id">ID:</label>
            <input type="text" class="form-control" id="update_campaign_id" name="update_campaign_id" readonly>
          </div>
          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="update_name" name="name">
          </div>
         
          <div class="form-group">
            <label for="end_date">End Date:</label>
            <input type="date" class="form-control" id="update_end_date" name="end_date">
          </div>
          <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="update_description" name="description"></textarea>
          </div>
          <div class="form-group">
                    <label for="status">Status:</label>
                    <input type="text" class="form-control" id="status" name="status" readonly value="Active">
                </div>
          
          <div class="form-group">
            <label for="social_media">Social Media:</label>
            <input type="text" class="form-control" id="update_social_media" name="social_media">
          </div>

          <button type="submit" class="btn btn-primary" name="update_campaign">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>

       
   
   
</body>

<script>
  $(document).ready(function() {
    // When an edit button is clicked
    $('.edit-campaign').click(function() {
      // Get the campaign data from the button's data attributes
      var campaignId = $(this).data('id');
      var campaignName = $(this).data('name');
      var campaignEndDate = $(this).data('end-date');
      var campaignDescription = $(this).data('description');
      var campaignSocialMedia = $(this).data('social-media');

      // Set the values of the input fields in the update campaign modal
      $('#update_campaign_id').val(campaignId);
      $('#update_name').val(campaignName);
      $('#update_end_date').val(campaignEndDate);
      $('#update_description').val(campaignDescription);
      $('#update_social_media').val(campaignSocialMedia);
    });
  });
</script>



</html>
