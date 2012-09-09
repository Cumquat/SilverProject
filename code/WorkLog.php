<?php
/**
 * Work Log
 * @author titledk
 * 
 */ 
class WorkLog extends DataObject {
	//database
	public static $db = array(
		"Title" => "Varchar",
		"Date" => "Date",
		"HoursSpent" => "Decimal",
    	"EstimatedHoursRemaining" => "Decimal",		
	);
	public static $has_one = array(
		"Task" => "Task"
	);
	public static $has_many = array();
	public static $many_many = array(); 
	public static $belongs_many_many = array(); 

	//formatting
	public static $casting = array(); //adds computed fields that can also have a type (e.g. 
	//public static $field_labels = array("Name" => "Carrot Name");
	public static $singular_name = "Work Log";
	public static $plural_name = "Work Logs";

	static $summary_fields = array(
		'Title',
		'Task.Title',	
		'HoursSpent'
	); 		

 

	function getTaskTitle(){
	  return $this->Task()->Title;
	}

  /*function getMilestoneID(){
    $task = $this->Task();  
    return $task->Milestone()->ID;
  }
  function getMilestoneTitle(){
    $task = $this->Task();  
    return $task->Milestone()->Title;
  }*/

	//defaults
	/*
	public static $default_sort = "Sort ASC, Name ASC";
	public static $defaults = array();//use fieldName => Default Value
	public function populateDefaults() {
		parent::populateDefaults();
	}
	*/

 function getCMSFields() { 
		$fields = parent::getCMSFields();
		$fields->addFieldToTab( "Root.Main", $dateField = new DateTimeField( "Date", "Date" ));
		 
		$dateField->getDateField()->setConfig('showcalendar', true); 
      
      	$dateField->getDateField()->setConfig('dateformat', 'dd/MM/YYYY');
	return $fields; 
	}


}