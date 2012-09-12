<?php

class AddTaskPage extends Page {

	

}
class AddTaskPage_Controller extends Page_Controller {

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

	
	 public function addtaskForm() {
	 		
			$project = Project::get()->map('ID', 'Title');
				
			DateField::set_default_config('showcalendar', true);
			DateField::set_default_config('dateformat', 'dd/MM/YYYY');
			$fields = new FieldList(
			
			new DropDownField( 'ProjectID', 'Project', $project),
            new TextField('Title'),
            new TextAreaField('Description'),
			new DropDownField( "Status", "Status", singleton('Task')->dbObject('Status')->enumValues()),
			new DateField( 'DueDate', 'Due Date'),
			new NumericField('OriginalHourEstimate', 'Est. in Hours')
			
        );
         
       $actions = new FieldList(
			new FormAction('dotaskadd', 'Submit')
		);
		
		return new Form($this, 'addtaskForm', $fields,  $actions);
		}
	
	function dotaskadd($data, $form) {
		$submission  = new Task();
		$submission ->write();
		$form->saveInto($submission );
		$submission ->write();
      	Controller::curr()->redirectBack();
		}
	
	
	
	
	
}