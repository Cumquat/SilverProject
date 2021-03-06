<?php

class TaskPage extends Page {

	

}
class TaskPage_Controller extends Page_Controller {
static $allowed_actions = array(
        'show',
		'edit',
		'addWorkForm',
		'tasklist',
		'editTaskForm'
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
	function edit() 
	{		
		if($task = $this->getTask())
		{
			$Data = array(
				'Task' => $task
			);
			
			//return our $Data to use on the page
			return $this->Customise($Data)->renderWith(array('Edittask', 'Page'));
		}
		else
		{
			//Staff member not found
			return $this->httpError(404, 'Sorry that Task could not be found');
		}
				
	}
	public function tasklist() {
	
		$gridFieldConfig = GridFieldConfig::create()->addComponents(
			new GridFieldToolbarHeader(),
            
			new GridFieldSortableHeader(),
			new GridFieldDataColumns(),
			new GridFieldPaginator(5),
			new GridFieldEditButton(),
			new GridFieldDeleteAction(),
			new GridFieldDetailForm()
		);
		$fields = new FieldList(
			$gridField = new GridField('TaskGrid', 'Example grid', new DataList('Task'),  $gridFieldConfig)
	
	 );
	$actions = new FieldList(
	  
		);
		
		return new Form($this, 'tasklist', $fields,  $actions);
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
	
	function editTaskForm(){
		$task = $this->getTask();		
		
	 		
			DateField::set_default_config('showcalendar', true);
			DateField::set_default_config('dateformat', 'dd/MM/YYYY');
			
			$fields = new FieldList(
			new HiddenField('ID', 'aID'),
			new LiteralField ("LiteralField","<div class='addForm'>" ),
				new LiteralField ("LiteralField","<div class='formleft'>" ),
					new TextField('Title'),
					
					new DateField('DueDate', 'Due Date'),
				new LiteralField ("LiteralField","</div>" ),
					new LiteralField ("LiteralField","<div class='formright'>" ),
						new TextAreaField('Description','Description'),
					new LiteralField ("LiteralField","</div>" ),
				new LiteralField ("LiteralField","<div class='formleft'>" ),
					
					new LiteralField ("LiteralField","<div class='checkboxes'>" ),
						new OptionSetField('Status','Status',singleton('Task')->dbObject('Status')->enumValues()),
					new LiteralField ("LiteralField","</div>" ),
					
				new LiteralField ("LiteralField","</div>" ),
			new LiteralField ("LiteralField","</div>" )
			
			);
		
		
		$actions = new FieldList(
		new LiteralField ("LiteralField","<div class='addForm'>" ),
		new LiteralField ("LiteralField","<div class='formright'>" ),
			new FormAction("dosave", "Save"),
		new LiteralField ("LiteralField","</div>" ),
		new LiteralField ("LiteralField","</div>" )
		);
		$form = new Form($this, 'editTaskForm', $fields, $actions);
		$Params = $this->getURLParams();
		if(is_numeric($Params['ID']) && $edittask = DataObject::get_by_id('Task', $Params['ID']))
		$form->loadDataFrom($edittask->data());
			
		return $form;
		
	}
	function dosave($data, $form){
		
		$theID = $_POST["ID"];
		$project = DataObject::get_by_id("Task", $theID);
		$form->saveInto($project);
		$project->write();

			Controller::curr()->redirect("tasks/show"  . '/' .$theID);
		
	}
		
	
	
	
	
}