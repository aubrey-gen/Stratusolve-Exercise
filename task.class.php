<?php
/**
 * This class handles the modification of a task object
 */
class Task {
    public $TaskId;
    public $TaskName;
    public $TaskDescription;
    protected $TaskDataSource;
    public function __construct($Id = null) {
        $this->TaskDataSource = file_get_contents('Task_Data.txt');
        if (strlen($this->TaskDataSource) > 0)
            $this->TaskDataSource = json_decode($this->TaskDataSource); // Should decode to an array of Task objects
        else
            $this->TaskDataSource = array(); // If it does not, then the data source is assumed to be empty and we create an empty array

        if (!$this->TaskDataSource)
            $this->TaskDataSource = array(); // If it does not, then the data source is assumed to be empty and we create an empty array
        if (!$this->LoadFromId($Id))
            $this->Create();
    }
    protected function Create() {
        // This function needs to generate a new unique ID for the task
        // Assignment: Generate unique id for the new task
        $this->TaskId = $this->getUniqueId();
        $this->TaskName = 'New Task';
        $this->TaskDescription = 'New Description';
    }
    protected function getUniqueId() {
        // Assignment: Code to get new unique ID
        return uniqid("", true); // Placeholder return for now
    }
    protected function LoadFromId($Id = null) {
        if ($Id) {
            // Assignment: Code to load details here...

            foreach( $this->TaskDataSource as $utask ){ 

                if($utask->TaskId == $id){

                    $this->TaskId = $this->TaskDataSource[$Id]->TaskId;
                    $this->TaskName = $this->TaskDataSource[$Id]->TaskName;
                    $this->TaskDescription = $this->TaskDataSource[$Id]->TaskDescription;
                    break;
                }
            }

        } else
            return null;
    }

    //public function Save($tmode, $task_info) {
    public function Save($tmode, $taskname, $taskdesc, $taskid = "") {
        //Assignment: Code to save task here
        
        $this->TaskDataSource = file_get_contents('Task_Data.txt');

        if (strlen($this->TaskDataSource) > 0){
            $this->TaskDataSource = json_decode($this->TaskDataSource); 
        }
        else{
            $this->TaskDataSource = array();
        }

        if ($tmode == 'new') {
            $this->Create();         
        }

        $this->TaskName = $taskname;
        $this->TaskDescription = $taskdesc;

        if($tmode == 'new'){
                        
            $task = new stdClass();
            $task->TaskId = $this->TaskId;
            $task->TaskName = $this->TaskName;
            $task->TaskDescription = $this->TaskDescription;

            array_push($this->TaskDataSource, $task);  
            
        }

        if ($tmode == 'edit') {

            foreach( $this->TaskDataSource as $currenttask ){ 

                if($currenttask->TaskId == $taskid){
                    $currenttask->TaskName = $this->TaskName;
                    $currenttask->TaskDescription = $this->TaskDescription;
                    break;
                }
            }
        }   
        
        $this->update_json();

    }
    protected function update_json(){

        file_put_contents('Task_Data.txt', json_encode($this->TaskDataSource, JSON_PRETTY_PRINT));
    }
    public function Delete($taskid) {
        //Assignment: Code to delete task here
        $this->TaskDataSource = array();
        $this->TaskDataSource = file_get_contents('Task_Data.txt');

        if (strlen($this->TaskDataSource) > 0){
            $this->TaskDataSource = json_decode($this->TaskDataSource); 
        }
        else{
            return;
        }

        $task_deleted = false;

        foreach( $this->TaskDataSource as $key => $utask ){ 

            if($utask->TaskId == $taskid){

                $task_deleted = true;
                unset($this->TaskDataSource[$key]);
                break;
            }
        }        

        if($task_deleted == true){

            //https://www.php.net/manual/en/function.json-encode.php#94157
            $temp_arr = array();
            $temp_arr = array_values($this->TaskDataSource);
            $this->TaskDataSource = $temp_arr;

            $this->update_json();
        }
        
    }
}

?>