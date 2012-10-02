<?php

  
class Task extends DataObject  {
   
 	public static $db = array( 
   		'Title' => 'Varchar()',
		'Description' => 'Text',
		'Status' => "Enum('Active, Completed, Cancelled, Suspended, Standby, Deleted', 'Active')",
		'DueDate' => 'Date',
		'OriginalHourEstimate' => 'Decimal',
	);
	public static $has_one = array(
		'Project' => 'Project'
	);
	public static $has_many = array(
			'WorkLogs' => 'WorkLog',
	);
	public static $many_many = array(); 
	public static $belongs_many_many = array(); 

	//formatting
	public static $casting = array(); //adds computed fields that can also have a type (e.g. 
	public static $field_labels = array(
		
	);
	public static $singular_name = 'Task';
	public static $plural_name = 'Tasks';

	static $default_sort = 'Status, DueDate';
	
	static $searchable_fields = array(
     	
		
   );
	public static $summary_fields = array(
		'Title',
		'DueDate'
		
		
	); 	
	
	
	 function getCMSFields() { 
		$fields = parent::getCMSFields();
	  	
		
		$fields->addFieldToTab( "Root.Main", $dateField = new DateField( "DueDate", "Date Due" ));
		
		$dateField->setConfig('showcalendar', true); 
     	
      	$dateField->setConfig('dateformat', 'dd/MM/YYYY');
	return $fields; 
	}
	
	function HoursWorked(){
	  $logs = $this->WorkLogs();
    $hours = 0;
    if ($logs) {
      foreach ($logs as $log) {
        $hours = $hours + $log->HoursSpent;
      }
    }
    return $hours;
	}
	function getTotalHoursWorked(){
    $total = 0;
    $tasks = $this->Task();
    if ($tasks) {
      foreach ($tasks as $task) {
        $total = $total + $task->HoursWorked();
      }
    }
    return $total;
  }
   
   
   
   
   
  function EstimatedHoursRemaining(){
    if ($this->Status == "Completed") {
      return 0;
    }  
    $logs = $this->WorkLogs(NULL, NULL, NULL, NULL, "ID DESC");
    $hours = false;
    
    if ($logs) {
      foreach ($logs as $log) {
        //echo "test: " . $log->EstimatedHoursRemaining;       
        if ($log->EstimatedHoursRemaining > 0) {
          $hours = $log->EstimatedHoursRemaining;
        }
      }
    }

    if ($hours == 0) {
      $hours = $this->OriginalHourEstimate;
    }

    return $hours;
  }
 
  
	public function bak() {
	$stat = $this->Status;
	return ($stat == 'Completed');
	}
	
	public function bak1() {
	$thedate =  strtotime ($this->DueDate);
	$expireDate = date ( "Y-m-d" , $thedate );
	$todaysDate = date ( "Y-m-d" );
		
		return ($expireDate < $todaysDate ) ;
	}
	
	
	
	
	function eLink(){
		$page = SiteTree::get_one("TaskPage");
		$link = $page->Link() . "edit/" . $this->ID;
		return $link;		
	}
	
	
	function Link(){
		$page = SiteTree::get_one("TaskPage");
		$link = $page->Link() . "show/" . $this->ID;
		return $link;		
	}
	
	
}