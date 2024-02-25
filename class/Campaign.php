<?php
class Campaign {	
   
	private $userTable = 'crm_users';
	private $campaignTable = 'crm_campaign';	
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }	    
	
	public function listCampaigns(){
		
		$sqlQuery = "SELECT * FROM ".$this->campaignTable;
		
		if(!empty($_POST["order"])){
			$sqlQuery .= ' ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery .= ' ORDER BY id ASC ';
		}
		
		if($_POST["length"] != -1){
			$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}
		
		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result();	
		
		$stmtTotal = $this->conn->prepare("SELECT * FROM ".$this->campaignTable);
		$stmtTotal->execute();
		$allResult = $stmtTotal->get_result();
		$allRecords = $allResult->num_rows;
		
		$displayRecords = $result->num_rows;
		$records = array();		
		while ($campaign = $result->fetch_assoc()) { 				
			$rows = array();			
			$rows[] = $campaign['id'];
			$rows[] = $campaign['name'];			
			$rows[] = $campaign['description'];
			$rows[] = $campaign['start_date'];	
			$rows[] = $campaign['end_date'];		
			$rows[] = $campaign['status'];				
			$rows[] = '<button type="button" name="update" id="'.$campaign["id"].'" class="btn btn-warning btn-xs update"><span class="glyphicon glyphicon-edit" title="Edit">Edit</span></button>';			
			$rows[] = '<button type="button" name="delete" id="'.$campaign["id"].'" class="btn btn-danger btn-xs delete" ><span class="glyphicon glyphicon-remove" title="Delete">Delete</span></button>';			
			$records[] = $rows;
		}
		
		$output = array(
			"draw"	=>	intval($_POST["draw"]),			
			"iTotalRecords"	=> 	$displayRecords,
			"iTotalDisplayRecords"	=>  $allRecords,
			"data"	=> 	$records
		);
		
		echo json_encode($output);
	}

	public function insert(){
		
		if($this->name) {

			$stmt = $this->conn->prepare("
			INSERT INTO ".$this->campaignTable."(`name`, `description`, `start_date`, `end_date`, `status`)
			VALUES(?,?,?,?,?)");
		
			$this->name = htmlspecialchars(strip_tags($this->name));			
			$this->description = htmlspecialchars(strip_tags($this->description));
			$this->start_date = htmlspecialchars(strip_tags($this->start_date));
			$this->end_date = htmlspecialchars(strip_tags($this->end_date));
			$this->status = htmlspecialchars(strip_tags($this->status));			
			
			$stmt->bind_param("sssss", $this->name, $this->description, $this->start_date, $this->end_date, $this->status);
			
			if($stmt->execute()){
				return true;
			}		
		}
	}

	public function getCampaign(){
		if($this->campaign_id) {
			$sqlQuery = "
			SELECT *
			FROM ".$this->campaignTable."
			WHERE id = ?";		
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("i", $this->campaign_id);	
			$stmt->execute();
			$result = $stmt->get_result();
			$record = $result->fetch_assoc();
			echo json_encode($record);
		}
	}


	public function update(){		
		if($this->campaign_id) {				
			$stmt = $this->conn->prepare("
			UPDATE ".$this->campaignTable." 
			SET name = ?, description = ?, start_date = ?, end_date = ?, status = ?
			WHERE id = ?"); 			
			$this->name = htmlspecialchars(strip_tags($this->name));			
			$this->description = htmlspecialchars(strip_tags($this->description));
			$this->start_date = htmlspecialchars(strip_tags($this->start_date));
			$this->end_date = htmlspecialchars(strip_tags($this->end_date));
			$this->status = htmlspecialchars(strip_tags($this->status));				
			$stmt->bind_param("sssssi", $this->name, $this->description, $this->start_date, $this->end_date, $this->status, $this->campaign_id);			
			if($stmt->execute()){
				return true;
			}			
		}	
	}

	public function delete(){
		if($this->campaign_id) {			

			$stmt = $this->conn->prepare("
				DELETE FROM ".$this->campaignTable." 
				WHERE id = ?");

			$this->campaign_id = htmlspecialchars(strip_tags($this->campaign_id));

			$stmt->bind_param("i", $this->campaign_id);

			if($stmt->execute()){
				return true;
			}
		}
	} 
}
?>
