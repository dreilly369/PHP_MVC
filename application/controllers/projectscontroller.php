<?php

class ProjectsController extends Controller {

	function view() {
		$project = new Project();
		$image = new Image();
		$notes = new Notes();
		$notes = $notes->selectAll('WHERE project_id='.$_REQUEST['id']);
		$project = $project->select($_REQUEST['id']);
		$image = $image->select($project->Project->image_id);
		$this->set('project',$project);
		$this->set('notes',$notes);
		$this->set('image_url',$image->Image->location);
	}
	
	function testing(){
		$Project = new Project();
		$Project->showHasOne();
		$Project->showHasMany();
		$Project->where('id',$_REQUEST['id']);
		$proj = $Project->search();
		print_r($proj);
		$this->set('project',$proj);
	}
	
	function viewall() {
		if(!isset($_SESSION['logged_in_user']['id'])){
			$this->redirect_to("home_nli");	
		}
		$id = isset($_SESSION['logged_in_user']['id']) ? $_SESSION['logged_in_user']['id'] : $_REQUEST['id'];
		$proj = new Project();
		$usr = new User();
		$usr = $usr->select($id);
		$projects = $proj->query("SELECT * FROM projects WHERE user_id=".$usr['User']['id']);
		
		$this->set('projects',$projects);
		$this->set('user',$usr);
	}
	
	function add() {
		$todo = $_POST['todo'];
		$this->set('title','Success - My Todo List App');
		$this->set('todo',$this->Item->query('insert into items (item_name) values (\''.mysql_real_escape_string($todo).'\')'));	
	}
	
	function delete($id = null) {
		$this->set('title','Success - My Todo List App');
		$this->set('todo',$this->Item->query('delete from items where id = \''.mysql_real_escape_string($id).'\''));	
	}

}
