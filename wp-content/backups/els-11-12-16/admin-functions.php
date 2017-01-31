<?
/*
Plugin Name: Elearning Solutions
Description: a tutorial for world domination
Version:1.0
*/

wp_enqueue_script('els-js', '/wp-content/plugins/elearningSolutions/els.js', '1.0', true );
wp_enqueue_style('els-css', '/wp-content/plugins/elearningSolutions/els.css', '1.0', true);
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
require_once(ABSPATH . 'wp-content/plugins/elearningSolutions/frontend-functions.php');
// if(isset($_POST['meta_id'])){
//   echo 'sent';
//   exit();
// }


// $postVar = isset($_POST['complete']) ? $_POST['complete'] : NULL;
// function test(){
// if($postVar == 'complete'){
//   var_dump('test');
//     }
//  }
if(isset($_POST['admin_menu_form'])){
  //$connection = new msqli('localhost','otkinsey','komet1','eliteTrainingVideos');
  $firstName  = isset($_POST['els_first_name']) ? $_POST['els_first_name']  : '';
  $lastName   = isset($_POST['els_last_name'])  ? $_POST['els_last_name'] : '';
  $testDate   = isset($_POST['els_test_date'])  ? $_POST['els_test_date'] : '';
  $testName   = isset($_POST['els_test_name'])  ? $_POST['els_test_name'] : '';
  //var_dump($wpdb);
  if( $firstName != '' && $lastName != '' && $testDate != '' && $testName != '' ){
    $wpdb->insert('e_els_scheduledExams', array('firstName'=>"$firstName", 'lastName'=>"$lastName", 'examDate'=>"$testDate", 'score'=>NULL, 'testName'=>"$testName"));
    // $wpdb->insert('e_els_scheduledExams', array('firstName'=>'', 'lastName'=>"$testName", 'meta_key'=>'els_last_name', 'meta_value'=>$lastName));
    // $wpdb->insert('e_els_scheduledExams', array('firstName'=>'', 'lastName'=>"$testName", 'meta_key'=>'els_test_date', 'meta_value'=>$testDate));
    // $wpdb->insert('e_els_scheduledExams', array('firstName'=>'', 'lastName'=>"$testName", 'meta_key'=>'els_test_name', 'meta_value'=>$testName));
    //echo $wpdb->insert_id;
    header('Location: http://localhost:8888/practice/eliteTrainingVideos/wp-admin/admin.php?page=scheduled_exams');
  }
  else{
    header('Location: http://localhost:8888/practice/eliteTrainingVideos/wp-admin/admin.php?page=scheduled_exams&error=true');
  }
  exit();
}
else{
    add_action('admin_menu', 'add_scheduled_exam_menu');
    function add_scheduled_exam_menu(){
      add_menu_page('Scheduled Exam', 'Scheduled Exams', 'manage_options', 'scheduled_exams', 'output_scheduled_exams','',6);
    }
/*******************************************************************************
* FRONT END FUNCTIONS
*
*******************************************************************************/
function scheduled_exam_signin($username, $password){
  global $wpdb;
  $sql = "SELECT * FROM e_els_scheduledExams WHERE userName = '$username' AND password = '$password'";
  $query = $wpdb->get_results($sql);
  return $query;
}
function get_exam_name($id){
  global $wpdb;
  $sql = "SELECT post_name FROM e_posts WHERE ID = '$id'";
  $query= $wpdb->get_results($sql);
  return $query;
}
function get_presentation($name){
  global $wpdb;
  $sql = "SELECT ID FROM e_posts WHERE post_name = 'presentation-$name'";
  $query = $wpdb->get_results($sql);
  return $query;
}

function get_slides($id){
  global $wpdb;
  $sql = "SELECT meta_key, meta_value FROM e_postmeta WHERE post_id = '$id' AND meta_key LIKE 'wpcf-slide-%'";
  $query = $wpdb->get_results($sql);
  return $query;
}
/*******************************************************************************
* CUSTOM FIELD FUNCTIONS
*
*******************************************************************************/

# Get test questions from database
function get_exam_questions($post_id){
  global $wpdb;
  $sql= "SELECT * FROM e_postmeta WHERE post_id = '$post_id' AND meta_key LIKE 'wpcf-question-%'";
  $query = $wpdb->get_results($sql);
  return $query;
}

# Get multiple choice options from database
function get_multiple_choice_options($post_id){
  global $wpdb;
  $sql= "SELECT * FROM e_postmeta WHERE post_id = '$post_id' AND meta_key LIKE 'question%option%'";
  $query = $wpdb->get_results($sql);
  if($query){
    return $query;
  }
  else{
    return false;
  }
}

function get_multiple_choice_answers($post_id){
  global $wpdb;
  $sql= "SELECT * FROM e_postmeta WHERE post_id = '$post_id' AND meta_key LIKE 'question%answer%'";
  $query = $wpdb->get_results($sql);
  if($query){
    return $query;
  }
  else{
    return false;
  }
}

# Multiple Option inputs: Create multiple choice inputs & save/retreive input
add_meta_box('exam-question-options', 'Multipe Choice Options', 'multiple_choice_options', 'exam-object', 'normal', 'low');
function multiple_choice_options(){
  global $post;
  $custom = get_post_custom($post->ID);
  $questions = get_exam_questions($post->ID);
  // var_dump($custom);
  if(!$questions){
    # **** DEFAULT OUT PUT FOR ANSWER OPTIONS : REVISIT ******

    // echo "<h3>Question 1 Options</h3>";
    // $options=4;
    // for($o=1;$o<$options;$o++){
      ?>
      <!-- <label for="option-<? echo $o; ?>">option <? echo $o;?></label> -->
      <!-- <input meta-id="" class="multipleChoiceOption" placeholder="option <? echo $o; ?>" type="text" id="<? echo $post->ID; ?>" name="question-1-option-<? echo $o; ?>"> --><?
    //}
    ?>
    <!-- <label for="question-1-answer">Answer:</label><input meta-id="" id="<? echo $post->ID; ?>" class="multipleChoiceAnswer" type="text" name="question-1-answer" > -->
    <?
  }
  else{
    $q=1; $r =0; $a= 0;
    $options=get_multiple_choice_options($post->ID);
    $answers= get_multiple_choice_answers($post->ID);

    // var_dump($options);
    foreach($questions as $item){
      ?><h3 class="q-<? echo $q; ?>">Question <? echo $q; ?> Options</h3><?
      for($o=1;$o<4;$o++){
        // varr_dump($options[$a]->meta_value);
        ?>
        <? echo $a; ?>
        <input meta-id="<? echo $options[$a]->meta_id; ?>"  class="multipleChoiceOption q-<? echo $q; ?>" value="<? echo $options[$a]->meta_value; ?>" placeholder="option <? echo $o; ?>" type="text" id="<? echo $post->ID; ?>" name="question-<? echo $q; ?>-option-<?echo $o;?>">
        <?
        $a++;
      }
      ?>
        <label class="q-<? echo $q; ?>" for="question-<? echo $q; ?>-answer">Answer:</label>
        <input meta-id="<? echo $answers[$r]->meta_id; ?>" id="<? echo $post->ID; ?>" class="multipleChoiceAnswer q-<? echo $q; ?>" type="text" name="question-<? echo $q; ?>-answer" value="<? echo $answers[$r]->meta_value; ?>">
      <?
      $q++;
      $r++;
    }
  }
}

#<!-- Exam Question inputs: Create exam question inputs & retreive exam questions -->
add_meta_box('exam-questions', 'Exam Questions', 'exam_questions', 'exam-object', 'normal','high');
function exam_questions(){
  global $post;
  $a = 1;
  $custom = get_post_custom($post->ID);
  $output = $question['test_meta_function'][0];

    $questions = get_exam_questions($post->ID);

    // var_dump($questions);
    if(!$questions){
      ?>
      <div class="questionContainer">
        <div class="admin_data item-<? echo $a; ?>" style="position:relative;" meta-data= <? echo $item->meta_id; ?>>
        <label id="label_<? echo $a; ?>" for="" class="questionLabel item-<? echo ''?>">Question <? echo $a; ?></label>
        <input  id="input_1" class="examQuestion input-1" name="wpcf[question-1]" type="text">
        </div>
      </div>
        <div id='addQuestion' class="button">add question</div>
      <?
    }
    else{

      // var_dump($item);
  ?>
  <div class="questionContainer">
  <? foreach($questions as $item){ /*var_dump($item);*/?>


    <div class="admin_data item-<? echo $a; ?>" style="position:relative;" meta-data= <? echo $item->meta_id; ?>>
      <label class="" for='question-<? echo $a; ?>'> Question <?echo $a;?></label>
      <input  class="examQuestion input-<? echo $a; ?>" name="wpcf[question-<? echo $a;?>]" type="text" value='<? echo $item->meta_value; ?>'>
      <i n="<? echo $a; ?>" post-id="<? echo $post->ID; ?>" id="<? echo $item->meta_id; ?>" class="fa fa-times deleteExamQuestion" onclick="deleteExamQuestion(event)" style="position:absolute;top:38px;right:40px;"></i>
    </div>
  <? $a++; } /*end foreach loop*/ ?>
  </div>


    <div id='addQuestion' class="button">add question</div>
  <?
  }
  ?>
  <!-- end: exam question inputs -->

  <!-- Frontend Scripts: Javascript and JQuery scripts for this post-type -->
  <script>
    var $ = jQuery.noConflict();
    var addQuestionControl = document.querySelector('#addQuestion');
    var updateForm = document.querySelector('form[name=post]');
    var n = 1;  /* sets value of attribute "n" for post delete function */
    document.addEventListener('load', countExamQuestions, false);
    addQuestionControl.addEventListener('click', addExamQuestion, false);
    updateForm.addEventListener('submit', addMulitpleChoiceOption, false)


    function countExamQuestions(){
      var elements = document.getElementsClassName('examQuestion');
      var count = elements.length;
      return count;
    }

    function addExamQuestion(event){
      var itemCount = document.getElementsByClassName('examQuestion').length+1;
      var metaArray = document.getElementsByClassName('admin_data');
      var metaCount = document.getElementsByClassName('admin_data').length;
      var metaId = metaArray[metaCount-1].getAttribute('meta-data');
      var questionContainer = document.querySelector('.questionContainer');
      var newQuestion = '<div class="admin_data item-'+itemCount+'" style="position:relative;"><label class="item-'+metaId+'" id="label_'+itemCount+'" for="" class="questionLabel">Question '+itemCount+'</label><input id="input_'+itemCount+'" class="examQuestion item-'+metaId+' input-'+itemCount+'" name="wpcf[question-'+itemCount+']" type="text"><i n="'+n+'" id="'+n+'" class="fa fa-times deleteExamQuestion" onclick="deleteExamQuestion(event)" style="position:absolute;top:38px;right:40px;" /></div>';

      n = itemCount;
      if(n > 10){
        alert('no more than 10 questions permitted.');
        n = 1;
        return n;
      }
      if(n == 1){
        questionContainer.appendChild(newQuestion);
        console.log('[addExamQuestion] n is '+n);
        return n++;
      }
      else{
        console.log('[addExamQuestion] n is '+n);
        var currentInputVar = n;
        var previousInput = document.querySelector('.input-'+(currentInputVar-1)).value;

        $('.questionContainer').append(newQuestion);
        document.querySelector('.input-'+(n-1)).value = previousInput;/* populates existing inputs when new input is added */
        console.log('[addExamQuestion] n is '+n);
        return n++;
      }
    }

    function addMulitpleChoiceOption(event){
      event.preventDefault();
      var multipleChoiceOptions = document.getElementsByClassName('multipleChoiceOption');
      var multipleChoiceAnswers = document.getElementsByClassName('multipleChoiceAnswer');
      if(document.querySelector('.multipleChoiceOption')){
        var id = document.querySelector('.multipleChoiceOption').getAttribute('id');
      }
      else{
        var id = '';
      }

      var optionsArray = [];
      var answersArray = [];

      if( id != ''){
        if(multipleChoiceOptions[0].value == ""){
          alert('you must set multiple choice options [admin-functions.php line 210]');
          console.log('not set admin functions');
          return;
        }
      }

      console.log('values set...processing admin functions');
      for(var g=0;g<multipleChoiceOptions.length;g++){
        optionsArray.push({'meta_id':multipleChoiceOptions[g].getAttribute('meta-id'),'post_id':id,'meta_key':multipleChoiceOptions[g].getAttribute('name'),'meta_value':multipleChoiceOptions[g].value,});
      }
      for(var e=0;e<multipleChoiceAnswers.length;e++){
        answersArray.push({'meta_id':multipleChoiceAnswers[e].getAttribute('meta-id'),'post_id':id,'meta_key':multipleChoiceAnswers[e].getAttribute('name'),'meta_value':multipleChoiceAnswers[e].value,});
      }
      //console.log("options array: "+multipleChoiceOptions[0]['meta_value']);
      updateForm.submit();
      console.log('options array: '+optionsArray[0].meta_value);
      $.ajax({
        method:'POST',
        url:'../wp-content/plugins/elearningSolutions/ajax.php',
        data:{'function':'multipleChoiceOptions','options':optionsArray,'answers':answersArray},
        success:function(response){
          // console.log(optionsArray);
        }
      });
    }


    function deleteExamQuestion(event){
      var element = event.target;
      // event.preventDefault();
      var metaId = element.getAttribute('id');
      var postId = element.getAttribute('post-id');
      var nVar = element.getAttribute('n');
      var itemCount = document.getElementsByClassName('examQuestion').length+1;
      n = itemCount
      console.log('nVar is '+nVar+' and itemCount is '+itemCount);
      if(nVar == (itemCount-1)){
      $('.item-'+nVar+', .q-'+nVar).fadeOut('slow');
      setTimeout(function(){ $('.item-'+nVar+', .q-'+nVar).remove(); }, 500);

    }
    else{
      alert('caution: please remove items from the bottom of the list first.');
    }
      $.ajax({
        method:'POST',
        url:'../wp-content/plugins/elearningSolutions/ajax.php',
        data:{'id':metaId, 'function':'deleteExamQuestion', 'postId':postId,'n':nVar },
        success:function(){
          // console.log(metaId);
          // location.reload();
          if(n<nVar){
            var newElement = document.getElementById('input_'+nVar);
            var newLabel = document.getElementById('label_'+nVar);
            // newElement.setAttribute('id') = 'input_'+nVar-1;
            // newLabel.setAttribute('id') = 'label_'+nVar-1;
            // newElement.setAttribute('class') = 'examQuestion input-'+nVar-1;
            // newLabel.setAttribute('class') = 'item-'+nVar-1;
            // return n--;
          }
          // location.reload();
          console.log(n);
          return n--;
        }
      });
    }
    /* Add exam question into db via ajax - revisit */
    // function sendExamQuestions(){
    //   var examQuestions = document.getElementsByClassName('.examQuestion');
    //   for(var a=0;a<examQuestions.length;a++){
    //     var question_
    //   }
    // }
  </script>
  <!-- end: frontend scripts -->
  <?
}


/*******************************************************************************
* SELECT FUNCTIONS
*
*******************************************************************************/
  function get_els_post_ids(){
    global $wpdb;
    $str = "SELECT ID FROM e_posts where post_type ='exam-object'";
    $query = $wpdb->get_results($str, ARRAY_A);
    // echo ('admin-functions.php line 48 '); var_dump( $query);
    return $query;
  }
  function get_els_exam_firstNames(){
    global $wpdb;
    $str = "SELECT * FROM e_els_scheduledExams ";
    $query = $wpdb->get_results($str, OBJECT);
    $result = array();
    // var_dump($query);
    foreach($query as $item){
      $result[]=$item;
    }
    return $result;
  }
  function get_els_exam_firstName($id){
    global $wpdb;
    $str = "SELECT * FROM e_els_scheduledExams WHERE examID = '$id' ";
    $query = $wpdb->get_results($str, OBJECT);
    $result = array();
    // var_dump($query);
    foreach($query as $item){
      $result[]=$item;
    }
    return $result;
  }
  function get_els_exam_testName($id){
    global $wpdb;
    $str = "SELECT post_title FROM e_posts WHERE ID = '$id' ";
    $query = $wpdb->get_results($str, OBJECT);

    return $query;
  }
/*******************************************************************************
*
*  DELETE FUNCTIONS
*
*******************************************************************************/

function delete_schedule_assessment($id){
  global $wpdb;
  $str = "DELETE * from e_els_scheduledExams WHERE meta_id='$id'";
  $query = $wpdb->delete('e_els_scheduledExams', array('meta_id'=>$id));
  return $query;
}

  function output_scheduled_exams(){
      global $wpdb;
      $str = 'SELECT post_title, ID FROM e_posts WHERE post_type="exam-object"';
      $exam_options = $wpdb->get_results($str, ARRAY_A);
      // var_dump($exam_options);
    ?>

  <h1>Schedule a New Assessment</h1>
    <form class="scheduled_exams" action='' method="post">
    <!--form class="scheduled_exams" action='<? echo site_url('/wp-content/plugins/elearningSolutions/admin-functions.php'); ?>' method="post"-->
      <input class='firstName' name='els_first_name' type="text" placeholder='first name'>
      <input class='lastName' name='els_last_name' type="text" placeholder='last name'>
      <input class='testDate' name='els_test_date' type="date" placeholder='select date'>
      <select class='testName' name="els_test_name">
        <?

          foreach($exam_options as $option){
            echo "<option value='".$option['ID']."'>" . $option['post_title']. "</option>";
          }
        ?>
      </select>
      <input type="hidden" name="admin_menu_form" value="scheduled_exams">
      <button class='button'>submit</button>
    </form>
    <hr>
    <h1>Scheduled Assessments</h1>
      <div class="large-12 scheduled_exams">
        <div class="columns heading checkbox_column"><i class="fa fa-times "></i></div>
        <div class="large-2 columns heading">First Name</div>
        <div class="large-2 columns heading">Last Name</div>
        <div class="large-2 columns heading">Test Date</div>
        <div class="large-2 columns heading">Test Name</div>
        <div class="large-2 columns heading">Score</div>
      </div>
      <!-- <div class="large-12 columns scheduled_exams"> -->

    <?
      // $ids = get_els_post_ids();
      // var_dump($ids);
    // foreach( $ids as $id){
         $firstNames = get_els_exam_firstNames();
        //  var_dump($firstNames);
        if($firstNames){
        ?>
        <? foreach($firstNames as $item) { //  var_dump($item);
            $testName = get_els_exam_testName($item->testName);
            // var_dump($testName);
          ?>
        <div class="admin_row info_<? echo $item->examID; ?> columns" >
             <div class='admin_data checkbox_column columns'><i onclick='ajax_request(<? echo $item->examID; ?>);removeScheduledExam(<? echo $item->examID; ?>)' class='fa fa-times removeScheduledExam'></i></div>
             <div class="large-2 columns admin_data info_<? echo $item->examID; ?>" examID='<? echo $item->examID; ?>' columnName='firstName' onclick='updateScheduledExams(event)'><? echo $item->firstName; ?></div>
             <div class="large-2 columns admin_data info_<? echo $item->examID; ?>" examID='<? echo $item->examID; ?>' columnName='lastName' onclick='updateScheduledExams(event)'><? echo $item->lastName; ?></div>
             <div class="large-2 columns admin_data info_<? echo $item->examID; ?>" examID='<? echo $item->examID; ?>' columnName='examDate' onclick='updateScheduledExams(event)'><? echo $item->examDate; ?></div>
             <div class="large-2 columns admin_data info_<? echo $item->examID; ?>" examID='<? echo $item->examID; ?>' columnName='testName' onclick='updateScheduledExams(event)'><? echo $testName[0]->post_title; ?></div>
             <div class="large-2 columns admin_data info_<? echo $item->examID; ?>" examID='<? echo $item->examID; ?>' columnName='score' onclick='updateScheduledExams(event)'><? echo $item->score; ?></div>
         </div>
         <? } ?>
      <!-- </div> -->
    <!-- </div> -->
    <script>
    var $ = jQuery.noConflict();
    var elementContent;
      function ajax_request(id){
        var item_id = id;
        $.ajax({
          url:'../wp-content/plugins/elearningSolutions/ajax.php',
          method:'POST',
          data:{'id':item_id,'function':'deleteExam'},
          dataType:'html',
          success:function(results){
            console.log(results);
          },
          error:function(xhr, ajaxOptions, thrownError){
            console.log(xhr.status);
            console.log(xhr.responseText);
            console.log(thrownError);
          }
        });
      }

      // function updateExamQuestions(){
      //   var q = document.getElementsByClassName('examQuestion');
      //   var metaid, postid, metakey, metvalue,examQuestions=[];
      //   for(var a=0;a<q.length;a++){
      //     examQuestions.push('meta-id':q[a].document.getAttribute(''));
      //   }
      // }
      /*** THIS SEEMS TO BE A LEGACY FUNCTION THAT WAS LEFT INCOMPLETE.
      **** MAY NOT BE NEED SINCE ADD FUNCTION DISTINGUISHES BETWEEN
      **** INSERT AND UPDATE QUERIES- REVISIT ***/

      function removeScheduledExam(id){
        $('.admin_row.info_'+id).fadeOut(400);
      }

      function updateScheduledExams(event){
        var ajaxEvent = event;
        var elementClass = ajaxEvent.target.className;
        // console.log(ajaxEvent);

        if( elementClass.includes('update')){


          return;
        }
        else{
          var elementId= event.target.getAttribute('examid');
          var elementName = event.target.getAttribute('columnName');
          var elementContent = event.target.innerHTML;

          if(event.target.nodeName == 'INPUT'){
            return;
          }

          $('.info_'+elementId).removeClass('update');
          $('.ajaxControl').remove();
          $('.admin_data').removeClass('update');
          $('.updateColumn').remove();
          ajaxEvent.target.innerHTML+='<form class="updateColumn" action="" method="POST" style=""><input id="updateInput" name='+elementName+' value="'+elementContent+'"></form><i class="ajaxControl fa fa-times" id="ajaxCancel"></i><i id="ajaxSend" class="ajaxControl fa fa-check"></i>';
          var ajaxInput = document.querySelector('#updateInput');
          ajaxInput.addEventListener('change', function(){ elementContent = ajaxInput.value; return elementContent; }, false);

          var ajaxSendControl = document.querySelector('#ajaxSend');
          console.log(elementContent);
          ajaxSendControl.addEventListener('click', function(){ ajaxUpdate(ajaxEvent, elementContent); }, false);
          ajaxEvent.target.className += ' update';
        }
      }

    </script>
      <?
      exit();
      }/* endif line 164*/
      else{
        echo 'There currently no exams scheduled.';
        exit();
      }

        ?>
        <?  //}/* endforeach */  ?>

    <?

  }/* end output function */

  add_action('admin_menu', 'els_submenu');
function els_submenu() {
  add_submenu_page('edit.php?post_type=scheduled_exams', __('Exam Administration Page'), __('Manage Exams'), 'manage_options', 'manage_exams', 'els_manage_exams');
}
/*****************************************************************************
* Plugin Initialization Functions
*
******************************************************************************/

  /* Description: Create Tables for scheduled examas */
        global $els_makeTables;
        $els_makeTables_version = '1.0';
        function elsMakeTables(){
          global $wpdb;
          global $els_makeTables_version;

          $charset_collate = $wpdb->get_charset_collate();
          $tableName = $wpdb->prefix . 'els_scheduledExams';
          $sql =  "CREATE TABLE IF NOT EXISTS" . $tableName . "(
                  examID int(10) NOT NULL AUTO_INCREMENT,
                  firstName varchar(20),
                  lastName varchar(20),
                  userName varchar(20),
                  passcode varchar(20),
                  examDate varchar(10),
                  score int(3),
                  testName varchar(200),
                  PRIMARY KEY  (examID)
                );";

          dbDelta($sql);
        }
        register_activation_hook(__FILE__, 'elsMakeTables');

/* Description: Create custom post fields for exam questions */

/*******************************************************************************
* end of plugin
*******************************************************************************/
  }/* endif line: 36 */
?>
