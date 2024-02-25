<?php

include_once 'config/Database.php';
include_once 'class/User.php'; // Assuming you have a User class for managing users
include_once 'class/Campaign.php'; // Include the Campaigns class

$database = new Database();
$db = $database->getConnection();

$user = new User($db); // Instantiate the User class
$campaign = new Campaigns($db); // Instantiate the Campaigns class

if(!$user->loggedIn()) {
    header("Location: index.php");
    exit; // Terminate further execution
}

include('inc/header4.php');
?>
<title>phpzag.com : Demo Customer Relationship Management (CRM) System</title>
<script src="js/campaign.js"></script> <!-- Include the JavaScript file for handling campaigns -->
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
            </table>
        </div>
    
    
    <div id="campaignModal" class="modal fade">
        <div class="modal-dialog">
            <form method="post" action ="campaign_action.php" id="campaignForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"></button>
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Edit Campaign</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="control-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Campaign name" required>            
                        </div>

                        <div class="form-group">
                            <label for="start_date" class="control-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" placeholder="Start date" required>            
                        </div>  

                        <div class="form-group">
                            <label for="end_date" class="control-label">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" placeholder="End date" required>            
                        </div>

                        <div class="form-group">
                            <label for="description" class="control-label">Description</label>
                            <textarea class="form-control" id="description" name="description" placeholder="Campaign description" required></textarea>            
                        </div>

                        <div class="form-group">
                            <label for="status" class="control-label">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>                            
                        </div>

                        <div class="form-group">
                            <label for="social_media" class="control-label">Social Media</label>
                            <input type="text" class="form-control" id="social_media" name="social_media" placeholder="Social media channels" required>            
                        </div>                       
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id" id="id" />
                        <input type="hidden" name="action" id="action" value="" />
                        <input type="submit" name="save" id="save" class="btn btn-info" value="Save" />
                   
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
                
</div>
</body>
</html>
