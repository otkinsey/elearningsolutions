  /**************************************************
*  GLOBAL VARIABLES
***************************************************/

  var boxOne ;
  var boxTwo ;
  var animatedItems ;
  var animatedItemsNum ;
  var index ;
  var interval;
  var controls ;
  var rewind ;
  var advance ;
  var highlightedItems ;
  var hl_index ;
  var testControl ;
  var options ;
  var testVar ;
  var correctAnswers;
  var play ;
  var response, raw, totalQuestions, totalAnswers;
  var globalTestId
/**----------------------------------------------------
*
*
/**************************************************
*  TABLE OF FUNCTIONS
***************************************************
1.
2.
3.
4.
5.
6.
7.
8.
9.
10.
11.
12.
13.
14.
15.
**----------------------------------------------------
*
*
/**************************************************
*  1. TestInit
***************************************************/
function testInit(){
  boxOne = document.querySelector('.animateBox_1');
  boxTwo = document.querySelector('.animateBox_2');
  animatedItems = document.getElementsByClassName('textItem');
  animatedItemsNum = animatedItems.length;
  index = 0;
  totalQuestions = document.getElementsByClassName('question');
  interval;
  controls = document.querySelector('.controls_container');
  rewind = document.querySelector('#rwd');
  advance = document.querySelector('#fwd');
  highlightedItems = document.getElementsByClassName('counted');
  hl_index = 0;
  testControl = document.querySelector('.go-to-test');
  options = document.getElementsByClassName('option');
  testVar = 1;
  totalAnswers=0;
  correctAnswers = 0;
  play = document.querySelector('.play');
  // response, raw;
  console.log('initializing...');
  document.addEventListener('DOMContentLoaded', function(){ pauseAll();  assignCorrectAnswers(); console.log('test init'); });
  rewind.addEventListener('click', function(){rewindTextClick();}, false);
  advance.addEventListener('click', function(){advanceTextClick();}, false);
  play.addEventListener('click', function(){ playAudio();  }, false);
  pause.addEventListener('click', function(){pauseTextClick();}, false);
}

/********************************
* 2.
*********************************/
    function assignCorrectAnswers(){
      console.log('custom.js line 76: '+assignCorrectAnswers);
      for(var i=0;i<options.length;i++){
        options[i].addEventListener('click', function(e){ evaluate(e); });
        setAttributes(options[i],{'style':'display:block;'})
      }
    }
/********************************
* 3.
*********************************/
      function evaluate(e){
          var val = e.target.getAttribute('value');
          console.log('question value is: '+val);
          totalAnswers++;
          if(val=='t'){
            var nextQuestion = document.querySelector('.nextQuestion');
            nextQuestion.addEventListener('click',function nq(){ $('.overlay').fadeOut(); $('overlay').toggle(); $('.evalMessage').removeClass('moved');startTest();/*assignCorrectAnswers();*/nextQuestion.removeEventListener('click',nq);console.log(testVar);}, false);
            correctAnswers++;
            console.log('number of correct answers: '+correctAnswers);
            if (totalAnswers >= totalQuestions.length){
              var homeButton = document.querySelector('.complete');
              var score = (correctAnswers/totalAnswers)*100;
              var scoreStr = toString(score);
              if(scoreStr.lastIndexOf('.') > 0 ){
                var scoreFloat = scoreStr.substr(scoreStr.indexOf('.'));
                if(parseFloat(scoreFloat) >= .5){
                  score = (score-parseFloat(scoreFloat))+1;
                }
                else{
                  score = (score-parseFloat(scoreFloat));
                }
                console.log('processed score is: '+score);
              }
              console.log('test complete toggle overlay...number of correct answers: '+correctAnswers+'and total questions answered: '+totalAnswers);
              $('.overlay').toggle();
              $('.correct').removeClass('moved');
              $('.complete').addClass('moved');
              $('.score').html(score+'%');
              homeButton.addEventListener('click', function(){ sendScore(); location.reload(); });
              return true;
            }
            $('.correct').addClass('moved');
          }
          else{
            var incorrectNext = document.querySelector('.incorrect .nextQuestion');
            incorrectNext.addEventListener('click',function nq(){ $('.overlay').fadeOut(); $('overlay').toggle(); $('.evalMessage').removeClass('moved');startTest();/*assignCorrectAnswers();*/incorrectNext.removeEventListener('click',nq);console.log(testVar);}, false);
            // tryAgain.addEventListener('click',function(){ $('.overlay').fadeOut(); $('overlay').toggle(); $('.evalMessage').removeClass('moved');}, false);
            if (totalAnswers >= totalQuestions.length){
              var homeButton = document.querySelector('.complete');
              var score = (correctAnswers/totalAnswers)*100;
              var scoreStr = score.toString();
              if(scoreStr.lastIndexOf('.') > 0 ){
                var scoreFloat = scoreStr.substr(scoreStr.indexOf('.'));
                if(parseFloat(scoreFloat) >= .5){
                  score = (score-parseFloat(scoreFloat))+1;
                }
                else{
                  score = (score-parseFloat(scoreFloat));
                }
                console.log('processed score is: '+score);
              }
              console.log('test complete toggle overlay...number of correct answers: '+correctAnswers+'and total questions answered: '+totalAnswers);
              $('.overlay').toggle();
              $('.correct').removeClass('moved');
              $('.complete').addClass('moved');
              $('.score').html(score+'%');
              homeButton.addEventListener('click', function(){ sendScore(); location.reload(); });
              return true;
            }
            $('.incorrect').addClass('moved');
          }

          $('.overlay').toggle();

          console.log('total questions answered: '+totalAnswers+' and correct answers is: '+correctAnswers);
      }
/********************************
* 4.
*********************************/
      function startTest(){
        $('.question').removeClass('moved').attr('style','display:none;');
        $('.video_border, #welcome').fadeOut('slow');

        function removeControls(){
          $('.controls_container').removeClass('moved').attr('style', 'display:none;');
        }
        setTimeout(removeControls, 500);
        $('#question'+testVar).attr('style','display:block;').addClass('moved');
        /* add event handlers for the "evaluate" function*/

         //assignCorrectAnswers();
        if(testVar > 3 ){
          testVar = 1;
        }else{
          testVar++;
        }
        console.log('custom.js line 126: testVar is'+testVar);
        pauseAudio();
        return testVar;
      }
/********************************
* 5.
*********************************/
    function rewindTextClick(){
      var audio = document.getElementsByTagName('audio');

      console.log('function name: rewindTextClick() - line 157 int is: '+index);
        if( index < 1){
          index = 0;
          fwd.setAttribute('style' , 'display:inline');
          rwd.setAttribute('style' , 'display:none');
          return index;
        }

        else{
          console.log( 'function name: rewindTextClick() - line 163: index = '+index);
          index-=1;
          animateReset(index);
          console.log('[rewindTextClick] index is: '+index);
          console.log('[rewindTextClick] audioFile is: '+audio[index-1].src);
          pauseAll();
          audio[index-1].load();
          console.log( 'function name: rewindTextClick() - line 168: index = '+index);
          fwd.setAttribute('style' , 'display:inline');
          var goToTest = document.querySelector('.go-to-test');
          if(goToTest){
            goToTest.remove();
          }
          if(play.style.display == 'inline'){
            controlToggle();
          }
          return index;
        }
      }

/********************************
* 6.
*********************************/
      function advanceTextClick(){
        var audio = document.getElementsByTagName('audio');
        // console.log('function name: advanceTextClick() - line 147 animatedItemsNum is: '+animatedItemsNum);
          if( index == animatedItemsNum ){
            index = animatedItemsNum;
            fwd.setAttribute('style' , 'display:none');
            rwd.setAttribute('style' , 'display:inline');
            $(controls).append('<span onclick="startTest(), assignCorrectAnswers()" class="control go-to-test">go to test <i class="fa fa-arrow-right"></i></span> ');
            // console.log('line 141: Index limit reached index reset to: '+(animatedItemsNum-1));
            return index;
          }
          else{
              if( index == 0){
                animateIn(index);
              }
              else{
                animateOut(index-1);
                animateIn(index);
                // console.log( 'function name: advanceTextClick() - function #5 = '+index);
              }

              rwd.setAttribute('style' , 'display:inline');

              // console.log('[advanceTextClick] index is: '+index);
              // console.log('[advanceTextClick] audioFile is: '+audio[index].src);
              pauseAll();
              // playAudio();
              if(audio[index] ){
                audio[index].load();
                audio[index].play();
              }

              if(play.style.display == 'inline'){
                controlToggle();
              }
              // console.log( 'function name: advanceTextClick() - line 189: index = '+index);
              index+=1;
              console.log(index);
              return index;
          }
      }

/********************************
* 7.
*********************************/


/********************************
* 8.
*********************************/
        function pauseTextClick(){
            window.clearInterval(interval);
        }

/********************************
* 9.
*********************************/
        /* B. Add classes "move" and "moveOut" respectively with a 1500sms timeout*/
        function animateIn(int){
          if(index == 0){
            animatedItems[index].className += ' moved';
            // int +=1;
            // index = int;
          }
          else{
            console.log('line 237: index= '+int);
            animatedItems[int].className += ' moved';
            animatedItems[int-1].className = 'textItem movedOut';
            // int +=1;
            // index = int;
          }
        }

/********************************
* 10.
*********************************/
        function animateOut(int){
          if(int == 0){
            return;
          }
          else{
            animatedItems[int].className += ' movedOut';
            animatedItems[int].className = 'textItem moved';
          }
        }

/********************************
* 11.
*********************************/
      function animateReset(int){
        console.log('line 221: int = '+int);
        if(int == 0){
          animatedItems[int].className = 'textItem';
        }
        else{
          animatedItems[int].className = 'textItem';
          animatedItems[int-1].className = 'textItem moved';
        }
      }

/********************************
* 12.
*********************************/
      function displayText(param){
        var lastIndex = param-1;
        console.log('function name: displayText(); line 201 - index is: '+param)
        animatedItems[lastIndex].className = 'textItem moved';
      }

/********************************
* 13. Highlight functions
*********************************/
        function highlightPlay(){
          $('.highlight').removeClass('highlight');
          $(play).addClass('highlight');
        }
        function highlightAdvance(){
          $('.highlight').removeClass('highlight');
          $(advance).addClass('highlight');
        }
/********************************
* 14.
*********************************/
        function animateControls(){
          var controls = document.querySelector('.controls_container');
          controls.className += ' moved';
          highlightPlay();
        }

/********************************
* 15.
*********************************/
          function playAudio(){
            var audio = document.querySelector('.audio_'+index);
            var audioFiles = document.getElementsByTagName('audio');
            console.log('[playAudio] number of audio files: '+audioFiles.length);
            if(audio == null){
              return;
            }
            else{
              for(var a = 0;a<audioFiles.length;a++){
                audioFiles[a].pause();
                console.log('playAudio: pausing...');
              }
               audio.play();
               console.log('playAudio: playing...');
           }
            console.log('custom.js line 355: index is '+index);
          }

/********************************
* 16.
*********************************/
          function pauseAudio(event){
            console.log(event);
            var audio = document.querySelector('.audio_'+index);
            // var audio = document.querySelector('.audio');
            if(audio){
              audio.pause();
              console.log(audio);
            }
            else return;
          }

/********************************
* 17.
*********************************/
          function pauseAll(){
            var audioFiles = document.getElementsByTagName('audio');
            for(var a = 0;a<audioFiles.length;a++){
              audioFiles[a].pause();
            }
            console.log(' pauseAll paused');
          }

/********************************
* 18.
*********************************/
        function controlToggle(){
        if( play.style.display == 'inline'){
          play.style.display = 'none';
        }
        else{ play.style.display = 'inline'}
        if( pause.style.display == 'inline'){
          pause.style.display = 'none';
        }
        else{ pause.style.display = 'inline'}
          $('.control').removeClass('highlight');
        }

/********************************
* 19.
*********************************/
        function resizeVideo(){
          var videoSize = document.querySelector('video');
          videoSize.clientHeight = (window.innerHeight)*(.7147);
        }
/********************************
* 20.
*********************************/
function signin(event){
  event.preventDefault();

  var username = document.querySelector('#username').value;
  var password  = document.querySelector('#password').value;
  var overflow_container = document.querySelector('.overflow_container');

  $.ajax({
    method:'POST',
    url: 'wp-content/plugins/elearningSolutions/ajax.php',
    data:{'function' : 'sign-in', 'username':username, 'password':password },
    success:function (data1){
      if(data1 == "request failed.."){
        alert('username or password is incorrect');
        exit();
      }
      response = JSON.parse(data1);
      console.log(response);

      $('.signIn, header.site-header, hr').animate({ 'opacity':'.0001'}, '300ms');
      setTimeout(
        function(){
        //$('hr').hide();
        $('#section_five').attr('style', "min-height:1061px;");

        // setTimeout( function(){ $('html, body').animate({'scrollTop':'100px'}, 300); }, 200);
      }, 400);
      setTimeout( function(){ $('.signIn, header.site-header, hr').remove();}, 900);
      setTimeout( function(){ $('.presentation_container h1').attr('style','display:block'); $('.presentation_container h1').animate({'opacity':'1'}, 300); },2100);
      if(response){
      window.addEventListener('resize', resizePresentationArea );
      setTimeout(insertLogoAfterSlideTitle, 1500);
      setTimeout( function(){ /** closed on line 562 **/
        $('section.container').attr('style', "background:#777;");
        var video = document.querySelector('video');
        video.className += ' visible';

        setTimeout(function(){
            // $('.signIn').remove();
            setTimeout( function(){ overflow_container.style.display = "block"; }, 300);
            setTimeout(function(){
              setTimeout(advanceTextClick, 300);
              // highlightPlay();
              animateControls(); }, 100);
            }, 1500);
        var questionContainer = document.querySelector('.questions');
        var answerOptions = response.options;
        var answers = response.answers;
        var varMap = {1:'one',2:'two',3:"three",4:"four",5:"five",6:"six",7:"seven",8:"eight",9:"nine",10:"ten"};
        var imageVar=1;
        var slideVar =1;
        var audioVar=1;
        var a = 1, b=0,c=1,d=1;

        /********************************
        * resize video player *
        *********************************/
        var controls_row = document.querySelector('.controls_row');
        var video_container = document.querySelector('.presentation_container');
        var video = document.querySelector('video');

        video_container.style.minHeight = 0;
        setTimeout(function(){
          video_container.className += ' moved';
          controls_row.className += ' moved';
          video_container.style.minHeight = (window.innerHeight-80)+'px';
        }, 700);

        /********************************
        * html output for audio files *
        *********************************/
        response.audioFiles.forEach(function(element){
          var audioFileUrl = element.meta_value;
          console.log('custom.js line 418: '+element.meta_value);
          var audioTag = document.createElement('audio');
          var audioFileContainer = document.getElementById('audioFileContainer');
          setAttributes(audioTag, {'src':audioFileUrl, 'class':'audio_'+a, 'autoplay':'false'});
          for(var audioLoop=0;audioLoop<response.audioFiles.length;audioLoop++){
            if(response.audioFiles[audioLoop].meta_key == "wpcf-slide-audio-file-"+varMap[a]){
              setAttributes(audioTag, {'src':response.audioFiles[audioLoop].meta_value})
              audioFileContainer.appendChild(audioTag);
            }
          }
          audioVar++;
          a++;
        });

        /******************************************************
        * HTML output for presentation slides and test questions *
        **********************************************************/

        /*------------------------
        * Test questions
        ------------------------*/
        response.questions.forEach(function(element){
          var d=1;
          var questionContent = document.createTextNode(element.meta_value);
          var questionContainer = document.createElement('div');
          var headingContainer = document.createElement('h1');
          var questions = document.querySelector('.questions');
          setAttributes(questionContainer, {'id':'question'+c,'class':'question'});
          headingContainer.appendChild(questionContent);
          questionContainer.appendChild(headingContainer);
          questions.appendChild(questionContainer);
          answerOptions.forEach(function(el){
            var optionContainer = document.createElement('p');
            var optionContent = document.createTextNode(el.meta_value);
            if((el.meta_key == 'question-'+c+'-option-'+d) && (el.meta_key == answers[(c-1)].meta_value)){
              optionContainer.appendChild(optionContent);
              setAttributes(optionContainer, {'value':'t', 'class':'option question'+c,'id':'o'+d});
              questionContainer.appendChild(optionContainer);
              d++;
            }
            else if(el.meta_key == 'question-'+c+'-option-'+d){
              optionContainer.appendChild(optionContent);
              setAttributes(optionContainer, {'value':'f', 'class':'option question'+c,'id':'o'+d});
              questionContainer.appendChild(optionContainer);
              d++;
            }
            else{
              return true;
            }
          });
          c++;
        });

        /*------------------------
        * Presentation slides
        ------------------------*/

        // response.slides.forEach(function(element){
        for( var z=0;z<response.slides.length;z++){
          // console.log('[custom.js line 544] - processing slide index '+ z);
          var parser = new DOMParser();
          var element = response.slides[z];
          var parsedContent = parser.parseFromString(element.meta_value, "text/html");
          var newDiv = document.createElement('div');
          var newImage = document.createElement('img');
          var slidesArray = response.slides;
          var container = document.querySelector('.presentation_text');

          setAttributes(newDiv, {'class':'textItem', 'id':'slide-'+slideVar});
          newDiv.appendChild(parsedContent.firstChild);

          for( var slideLoop=1;slideLoop<slidesArray.length;slideLoop++){
            if(element){
                // console.log('[custom.js line 565] - z is '+z);
              if( element.meta_key == "wpcf-slide-"+varMap[slideLoop] ){
                // console.log('[custom.js line 567] - image '+varMap[slideLoop]+' selected...');
                // console.log('[custom.js line 568] - imageVar is '+imageVar);
                if( response.slides[imageVar] ){
                  // console.log('[custom.js line 570] - slides array is '+response.slides.length);
                  if(response.slides[imageVar].meta_key == "wpcf-slide-"+varMap[slideLoop]+"-image"){
                    setAttributes(newImage,{'src': response.slides[imageVar].meta_value, 'class':'slide_image'});
                    newDiv.appendChild(newImage);
                    container.appendChild(newDiv);
                    // console.log('[custom.js line 574] - image #'+varMap[slideLoop]+' added...');
                    // console.log('[custom.js line 574] - slide #'+varMap[slideLoop]+' added...');
                  }
                  else{
                    console.log('[custom.js line 566] - image file #'+imageVar+' not defined...continuing loop');
                    container.appendChild(newDiv);
                  }
                }
                else{
                  // console.log('[custom.js line 570] - imageVar is '+varMap[imageVar]+' is defined');
                  if(response.slides[z].meta_key == "wpcf-slide-"+varMap[slideLoop]+"-image"){
                    setAttributes(newImage,{'src': response.slides[imageVar].meta_value, 'class':'slide_image'});
                    newDiv.appendChild(newImage);
                    container.appendChild(newDiv);
                    // console.log('[custom.js line 574] - image #'+varMap[slideLoop]+' added...');
                    // console.log('[custom.js line 574] - slide #'+varMap[slideLoop]+' added...');
                  }
                  else{
                    // console.log('[custom.js line 566] - image file #'+imageVar+' not defined...continuing loop');
                    container.appendChild(newDiv);
                  }
                }
              }
            }
            else {
              console.log('[custom.js line 566] - slide '+z+' not defined...breaking loop');
              break
            }
          }
          imageVar+=1;
          slideVar+=1;

        };
        testInit();
        pauseAll();
      }, 1000); /** ref line 437 **/
      }
      else{
        alert('No response. There was a database error');
      }
    },

    error:function(){
      response = 'request failed...';
    }
  });
  // setTimeout( function(){ $('html, body').animate({'scrollTop':'100px'}, 300); }, 500);
  setTimeout(function(){ highlightAdvance(); }, 24000);
}
/********************************
* 21.
*********************************/
// function setAttributes(el, attrs){
//   for(var key in attrs){
//     el.setAttribute(key, attrs[key]);
//   }
// }
function setAttributes(el, attrs){
  for(var key in attrs){
    el.setAttribute(key, attrs[key])
  }
}
/********************************
* 22. Description: send score to
----- database.
*********************************/
function sendScore(){
  var scoreString = document.querySelector('.score').innerHTML;
  var score = scoreString.substr(0,scoreString.indexOf('%'));
  var examId = response.userInfo[0].examID;
  console.log('score: '+score+' id: '+examId);
  $.ajax({
    method:'POST',
    url:'wp-content/plugins/elearningSolutions/ajax.php',
    data: {'function':'sendScore','score' : score,'examId' : examId},
    success:function(data){

      console.log('score successfully added.. the response is '+data);
    }
  });
}

/********************************
* 23. Resize presentation area
----- database.
*********************************/
function resizePresentationArea() {
  var controls_row = document.querySelector('.controls_row');
  var video_container = document.querySelector('.presentation_container');
  var video = document.querySelector('video');

  video_container.style.minHeight = 0;
  setTimeout(function(){
    video_container.className += ' moved';
    controls_row.className += ' moved';
    video_container.style.minHeight = (window.innerHeight-80)+'px';
  }, 500);
}

/********************************
* 24. Add logo after slide title
*********************************/
function insertLogoAfterSlideTitle(){
  $('.textItem h1').prepend('<img src="http://localhost:8888/practice/elearningsolutions/wp-content/uploads/2016/05/elearningsolutions.png" alt="elearningsolutions" width="200" height="200" class="alignnone size-full wp-image-188" />');
}
