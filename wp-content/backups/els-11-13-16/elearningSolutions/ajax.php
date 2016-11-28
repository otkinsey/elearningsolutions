<?
/*******************************************************************************
* File Name: Ajax.php
* Description: This file is used to process ajax requests and modify the
* database accordingly
* version: 1.0 beta
*******************************************************************************/

# TABLE OF FUNCTIONS:
/*--------------------
1. Add Questions
2.
--------------------*/
require '../../../wp-load.php';
require_once 'admin-functions.php';

wp_enqueue_script('jquery');
$function = $_POST['function'];
function logger($query) {
  $logFile = 'log.php';
  $handle = fopen($logFile, 'a+');
  $write = fwrite($handle, $query . "\r\n");
  fclose($handle);
}
/*******************************************************************************
* 1. ADD QUESTIONS
*******************************************************************************/
if($function == 'addQuestion'){
  function processAjax(){
    global $wpdb;
      $options = $_POST['questions'];
      $test = get_multiple_choice_options($options[0]['post_id']);
      if(isset($options) && !$test){
          for( $o=0;$o<count($options);$o++){
            $query = $wpdb->insert('e_postmeta',array('meta_id'=>'','post_id'=>$options[$o]['post_id'],'meta_key'=>$options[$o]['meta_key'],'meta_value'=>$options[$o]['meta_value']));
          }
      }
      else{
          for( $o=0;$o<count($options);$o++){
            $query = $wpdb->update('e_postmeta',array('meta_id'=>'','post_id'=>$options[$o]['post_id'],'meta_key'=>$options[$o]['meta_key'],'meta_value'=>$options[$o]['meta_value']), array('post_id'=>$options[$o]['post_id']));
          }
      }
      return $id;
      die();
  }
  processAjax();
  add_action('wp_ajax_processAjax', 'processAjax');
  add_action('wp_ajax_nopriv_processAjax', 'processAjax');
}

/*******************************************************************************
* 2. DELETE EXAM
*******************************************************************************/
if($function == 'deleteExam'){
  function processAjax(){
    global $wpdb;
      $id = $_POST['id'];
          // var_dump($id);
      if(isset($id)){
          $id = isset($id) ? $id : '';
          $query = $wpdb->query($wpdb->prepare("DELETE FROM e_els_scheduledExams WHERE examID = '$id'"));
          // var_dump($id);
      }
      return $id;
      die();
  }
  processAjax();
  add_action('wp_ajax_processAjax', 'processAjax');
  add_action('wp_ajax_nopriv_processAjax', 'processAjax');
}

/*******************************************************************************
* 3. DELETE EXAM QUESTIONS
*******************************************************************************/
if($function == 'deleteExamQuestion'){
  function processAjax(){
    global $wpdb;
      $id = $_POST['id'];
      $postId = $_POST['postId'];
      $qnum = $_POST['n'];
          // var_dump($id);
      if(isset($id)){
          $query = $wpdb->query("DELETE FROM e_postmeta WHERE meta_id = $id");
          $query2 = $wpdb->query("DELETE FROM e_postmeta WHERE post_id = $postId AND meta_key LIKE 'question-$qnum-option%'");
          $query3 = $wpdb->query("DELETE FROM e_postmeta WHERE post_id = $postId AND meta_key LIKE 'question-$qnum-answer'");
          logger("DELETE FROM e_postmeta WHERE meta_id =  $id");
          logger("DELETE FROM e_postmeta WHERE post_id = $postId  AND meta_key LIKE question-$qnum-option%");
          logger("DELETE FROM e_postmeta WHERE post_id = $postId  AND meta_key LIKE question-$qnum-answer");
      }
      return $id;
      die();
  }
  processAjax();
  add_action('wp_ajax_processAjax', 'processAjax');
  add_action('wp_ajax_nopriv_processAjax', 'processAjax');
}

/*******************************************************************************
* 4. (Process) MULTIPLE CHOICE QUESTIONS
*******************************************************************************/
if($function == 'multipleChoiceOptions'){
  function processAjax(){
    global $wpdb;
      $options = $_POST['options'];
      $answers = $_POST['answers'];
      //  $valueTest = get_multiple_choice_options($options[0]['meta_value']);
      //  if(!$valueTest){
      //    logger('[File Name: AJAX.PHP] function: multipleChoiceOptions - Meta_value is not set.  No query run...exiting');
      //  }
          for( $o=0;$o<count($options);$o++){
            $test1 = get_multiple_choice_options($options[$o]['post_id'])[$o]->meta_id;
            if(!$test1){
              $query = $wpdb->insert('e_postmeta',array('meta_id'=>'NULL','post_id'=>$options[$o]['post_id'],'meta_key'=>$options[$o]['meta_key'],'meta_value'=>$options[$o]['meta_value']));
              logger("OPTION VARIABLES: query_type : INSERT | meta_id : ". $options[$o]['meta_id'] ." | post_id : ".$options[$o]['post_id']." | meta_key: ".$options[$o]['meta_key']." | meta_value: ".$options[$o]['meta_value']." | TEST-VALUE: ".$test1);
            }
            else{
              $query = $wpdb->update('e_postmeta',array('meta_id'=>$options[$o]['meta_id'],'post_id'=>$options[$o]['post_id'],'meta_key'=>$options[$o]['meta_key'],'meta_value'=>$options[$o]['meta_value']), array('meta_id'=>$options[$o]['meta_id']));
              logger("OPTION VARIABLES: query_type : UPDATE | meta_id : ". $options[$o]['meta_id'] ." | post_id : ".$options[$o]['post_id']." | meta_key: ".$options[$o]['meta_key']." | meta_value: ".$options[$o]['meta_value']." | TEST-VALUE: ".$test1);
            }
          }

          for( $a=0;$a<count($answers);$a++){
            $test2 = get_multiple_choice_answers($answers[$a]['post_id'])[$a]->meta_id;
            if(!$test2){
              $query = $wpdb->insert('e_postmeta',array('meta_id'=>'NULL','post_id'=>$answers[$a]['post_id'],'meta_key'=>$answers[$a]['meta_key'],'meta_value'=>$answers[$a]['meta_value']));
              logger("ANSWER VARIABLES: query_type : INSERT | meta_id : ". $answers[$a]['meta_id'] ." | post_id : ".$answers[$a]['post_id']." | meta_key: ".$answers[$a]['meta_key']." | meta_value: ".$answers[$a]['meta_value']." | TEST-VALUE: ".$test2);
            }
            else{
              $query = $wpdb->update('e_postmeta',array('meta_id'=>$answers[$a]['meta_id'],'post_id'=>$answers[$a]['post_id'],'meta_key'=>$answers[$a]['meta_key'],'meta_value'=>$answers[$a]['meta_value']), array('meta_id'=>$answers[$a]['meta_id']));
              logger("ANSWER VARIABLES: query_type : UPDATE | meta_id : ". $answers[$a]['meta_id'] ." | post_id : ".$answers[$a]['post_id']." | meta_key: ".$answers[$a]['meta_key']." | meta_value: ".$answers[$a]['meta_value']." | TEST-VALUE: ".$test2);
            }
          }

      die();
  }
  processAjax();
  add_action('wp_ajax_processAjax', 'processAjax');
  add_action('wp_ajax_nopriv_processAjax', 'processAjax');
}

/*******************************************************************************
* 5. UPDATE
*******************************************************************************/
if($function == 'update'){
  function processUpdate(){
    global $wpdb;
      $id = $_POST['id'];
      $col_name = $_POST['col_name'];
      $value = $_POST['value'];
          // var_dump($id);
      if(isset($id)){
          $id = isset($id) ? $id : '';
          $query = $wpdb->update();
          // var_dump($id);
      }
      return $id;
      die();
  }
  processUpdate();
  add_action('wp_ajax_processUpdate', 'processUpdate');
  add_action('wp_ajax_nopriv_processUpdate', 'processUpdate');
}
/*******************************************************************************
* 5. SIGN IN
*******************************************************************************/
if($function == 'sign-in'){
  function signIn(){
    $username = $_POST['username'];
    $password = $_POST['password'];
    if(!$username || !$password || $password == '' || $password == NULL || $username == '' || $username == NULL){
        echo 'username and password must be provided.';
        exit();
    }

    $signed_in = scheduled_exam_signin($username, $password);


    if(!$signed_in || $signed_in == '' || $signed_in == NULL){
        echo 'request failed..';
    }else{
          //  $_POST['response'] = "{\"examID\":\"".$signed_in[0]->examID."\",\"firstName\":\"".$signed_in[0]->firstName."\",\"lastName\":\"".$signed_in[0]->examID."\",\"username\":\"".$signed_in[0]->userName."\",\"examDate\":\"".$signed_in[0]->examDate."\",\"score\":\"NULL".$signed_in[0]->score."\",\"testName\":\"".$signed_in[0]->testName."\" }";
          // echo $signed_in;

          $test = get_exam_questions($signed_in[0]->testName);
          $answerOptions = get_multiple_choice_options($signed_in[0]->testName);
          $examName = get_exam_name($signed_in[0]->testName);
          $examNameArray = explode('-', $examName[0]->post_name);
          $presVar = get_presentation($examNameArray[1]);
          $presentation = get_slides($presVar[0]->ID);
          $answers = array();
          $questions = array();
          $slides = array();
            $a=1;$b=0;

          foreach($answerOptions as $option){
            $answers[]= $option;
          }
          foreach($test as $obj){
            $questions[]= $obj;
          }

          foreach($presentation as $slide){
            $slides[] = $slide;
          }
          //return '$signed_in';
          // var_dump($questions);
          // echo json_encode($examNameArray[1]);
          $dataObj = array('questions'=>$questions, 'answers'=>$answers, 'slides'=>$slides );
          echo json_encode($dataObj);
          die();
      }
    }
    signIn();
    add_action('wp_ajax_signIn', 'signIn');
    add_action('wp_ajax_nopriv_signIn', 'signIn');
  }

?>
