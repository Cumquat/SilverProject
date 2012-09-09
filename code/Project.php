<?php

  
class Project extends DataObject  {
   
 	public static $db = array( 
   		'Title' => 'Varchar()',
		'ShortDescription' => 'Varchar(70)',
		'Description' => 'HTMLText',
		'Status' => "Enum('Active, Completed, Cancelled, Suspended, Standby, Deleted', 'Active')",
		'Type' => "Enum('Client, Internal, Private, Idea, N.A.', 'N.A.')",
		'Priority' => "Enum('A. (High), B. (Medium), C. (Low), N.A.', 'N.A.')",
		'DueDate' => 'Date'	
	);
	public static $has_one = array(
		'Owner' => 'Member',
		'Requester' => 'Member'
		//'ProjectPage' => 'ProjectPage'
	);
	public static $has_many = array(
			'Tasks' => 'Task'
	);
	public static $many_many = array(
			'Scores' => 'Score',
			'Impacts' => 'Impact'
	); 
	public static $belongs_many_many = array(); 

	//formatting
	public static $casting = array(); //adds computed fields that can also have a type (e.g. 
	public static $field_labels = array(
		'ShortDescription' => 'Project One liner'
	);
	public static $singular_name = 'Project';
	public static $plural_name = 'Projects';

	static $default_sort = 'Priority, DueDate';
	
	static $searchable_fields = array(
     	
		
   );
	public static $summary_fields = array(
		'ID',
		'Title',
		'Owner.FirstName'
		
		
	); 	
	
	
	 function getCMSFields() { 
		$fields = parent::getCMSFields();
		
		$HSEAScore= GroupedList::create(Score::get()->sort('ClassName'));
		
		$fields->addFieldToTab("Root.Main", new CheckboxsetField('Scores', 'Check List', $HSEAScore));
		$impact= GroupedList::create(Impact::get()->sort('Title'));
		
		$fields->addFieldToTab("Root.Main", new CheckboxsetField('Impacts', 'Impact', $impact));
		
		//$FinScore= DataObject::get('Score' ,"ClassName = 'Financial'");
//		$fields->addFieldToTab("Root.Main", new CheckboxsetField('Scores', 'Financial', $FinScore));
//		$ServScore= DataObject::get('Score', "ClassName = 'Service'");
//		$fields->addFieldToTab("Root.Main", new CheckboxsetField('Scores', 'Service', $ServScore));
		
		
		
		$fields->addFieldToTab( "Root.Main", $dateField = new DatetimeField( "DueDate", "Date Due" ));
		
		$dateField->getDateField()->setConfig('showcalendar', true); 
     	$dateField->getTimeField()->setConfig('showdropdown', true); 
      	$dateField->getDateField()->setConfig('dateformat', 'dd/MM/YYYY');
	return $fields; 
	}
	
	
	public function pLink(){
		return  'projects/show/' . $this->ID; 
			
	}
	public function nLink() {
		return Controller::join_links(Director::baseURL(), 'project/show', $this->ID);
	}
	function Link(){
		$page = SiteTree::get_one("ProjectPage");
		$link = $page->Link() . "show/" . $this->ID;
		return $link;		
	}
	function getTotalHoursWorked(){
    $total = 0;
    $tasks = $this->Tasks();
    if ($tasks) {
      foreach ($tasks as $task) {
        $total = $total + $task->HoursWorked();
      }
    }
    return $total;
  }
	
	function getTotalHoursEstimated(){
    $total = 0;
    $tasks = $this->Tasks();
    if ($tasks) {
      foreach ($tasks as $task) {
        $total = $total + $task->EstimatedHoursRemaining();
      }
    }
    
    return $total;
  }  
	
  function getOriginalHoursEstimated(){
		$total = 0;
		$tasks = $this->Tasks();
		if ($tasks) {
			foreach ($tasks as $task) {
				$total = $total + $task->OriginalHourEstimate;
			}
		}
		
		return $total;
	}
	 function getTotalHoursEstimatedAndWorked(){
    $total = 0;
    $total = $this->getTotalHoursWorked() + $this->getTotalHoursEstimated();
    return $total;
  }   
  function PercentComplete(){
    $worked = $this->getTotalHoursWorked();
    $remaining = $this->getTotalHoursEstimated();
    if (($worked > 0) && ($remaining > 0)) {
      $completion = $worked / ($remaining + $worked);
      return round($completion * 100) . "%";
    } else {
      return false;
      //return "N.A.";
    }
  } 
  
	
	public function getTheScores() {
        $score1 = $this->Scores();
		return $score1;
    }
	
	
	public function ProjectScore() { 
		$ProjID = $this->ID;
      $results = DB::query('SELECT  sc.Title AS STitle,  sc.ClassName AS SClassName,
(
  select count(Project.ID) from Project 
  LEFT JOIN Project_scores on Project_scores.ProjectID = Project.ID 
  where sc.ID = Project_scores.ScoreID
  and Project.ID = ' . $ProjID . '
) as Score
FROM Score sc '); 
      $thescore = ArrayList::create(); 
      for ($i = 0; $i < $results->numRecords(); $i++) { 
   $record = $results->nextRecord(); 
         $thescore->add(new ArrayData( array('STitle' => $record['STitle'], 'SClassName' => $record['SClassName'],'Score' => $record['Score'] ) )); 
    	} 
            
           return GroupedList::create($thescore) ;
      
  		}
		
		public function TheImpact() { 
		$ProjID = $this->ID;
      $results = DB::query('SELECT  ip.Title AS ITitle,  ip.ClassName AS IClassName,
(
  select count(Project.ID) from Project 
  LEFT JOIN Project_impacts on Project_impacts.ProjectID = Project.ID 
  where ip.ID = Project_impacts.ImpactID
  and Project.ID = ' . $ProjID . '
) as Impact
FROM Impact ip ORDER by ip.Title'); 
      $thescore = ArrayList::create(); 
      for ($i = 0; $i < $results->numRecords(); $i++) { 
   $record = $results->nextRecord(); 
         $thescore->add(new ArrayData( array('ITitle' => $record['ITitle'], 'Impact' => $record['Impact'] ) )); 
    	} 
            
           return GroupedList::create($thescore) ;
      
  		}
   
    
	
	
}