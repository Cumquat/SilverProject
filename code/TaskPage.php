<?php

class TaskPage extends Page {

	

}
class TaskPage_Controller extends Page_Controller {
static $allowed_actions = array(
        'show',
		'addWorkForm'
    ); 
	public function init() {
		parent::init();
		Requirements::css("project/css/project.css");
			
		
	}
	public function Tasks() {
	$tasks = Task::get();
	return $tasks;
	}
	
	public function getTask(){
		$Params = $this->getURLParams();
		
		if(is_numeric($Params['ID']) && $task = DataObject::get_by_id('Task', $Params['ID']))
		{		
			return $task;
		}
		
	}
	public function getTaskID(){
		$Params = $this->getURLParams();
		
		if(is_numeric($Params['ID']) && $task = DataObject::get_by_id('Task', $Params['ID']))
		{		
			return $task->ID;
		}
		
	}
	function show() 
	{		
		if($task = $this->getTask())
		{
			$Data = array(
				'Task' => $task
			);
			
			//return our $Data to use on the page
			return $this->Customise($Data)->renderWith(array('TheTask', 'Page'));
		}
		else
		{
			//Staff member not found
			return $this->httpError(404, 'Sorry that callout could not be found');
		}
				
	}
	public function addWorkForm() {
	 		
			$thetask = $this->getTaskID();
							
			DateField::set_default_config('showcalendar', true);
			DateField::set_default_config('dateformat', 'dd/MM/YYYY');
			
			$fields = new FieldList(
			new LiteralField ("LiteralField","<h3>Add a Work Log</h3>" ),
			new HiddenField( 'TaskID', '', $thetask),
			new LiteralField ("LiteralField","<table class='standard'>" ),
			new LiteralField ("LiteralField","<thead>" ),
			new LiteralField ("LiteralField","<tr>" ),
			new LiteralField ("LiteralField","<th>Date</th>" ),
			new LiteralField ("LiteralField","<th>Title</th>" ),
			new LiteralField ("LiteralField","<th>Hours Spent</th>" ),
			new LiteralField ("LiteralField","<th>Hours Remaining</th>" ),
			new LiteralField ("LiteralField","<th>&nbsp;</th>" ),
			new LiteralField ("LiteralField","</tr>" ),
			new LiteralField ("LiteralField","</thead>" ),
			new LiteralField ("LiteralField","<tbody>" ),
			new LiteralField ("LiteralField","<tr>" ),
			new LiteralField ("LiteralField","<td>" ),
				new DateField('Date', ''),
			new LiteralField ("LiteralField","</td>" ),
			new LiteralField ("LiteralField","<td>" ),
				new TextField( 'Title', ''),
			new LiteralField ("LiteralField","</td>" ),
				new LiteralField ("LiteralField","<td>" ),
				new NumericField('HoursSpent', ''),
			new LiteralField ("LiteralField","</td>" ),
				new LiteralField ("LiteralField","<td>" ),
				new NumericField('EstimatedHoursRemaining', '','0'),
			new LiteralField ("LiteralField","</td>" )
			
			
			
        );
         
       $actions = new FieldList(
	   new LiteralField ("LiteralField","<td>" ),
			new FormAction('doworkadd', 'Submit'),
			new LiteralField ("LiteralField","</td>" ),
			new LiteralField ("LiteralField","</tr>" ),
			new LiteralField ("LiteralField","<tbody>" ),
			new LiteralField ("LiteralField","</table>" )
		);
		
		return new Form($this, 'addWorkForm', $fields,  $actions);
		}
	
	function doworkadd($data, $form) {
		$submission  = new WorkLog();
		$submission ->write();
		$form->saveInto($submission );
		$submission ->write();
      	Controller::curr()->redirectBack();
		}
	
	
		
	
	
	
	
}