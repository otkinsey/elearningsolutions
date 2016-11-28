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
  var response, raw;

function testInit(){
  boxOne = document.querySelector('.animateBox_1');
  boxTwo = document.querySelector('.animateBox_2');
  animatedItems = document.getElementsByClassName('textItem');
  animatedItemsNum = animatedItems.length;
  index = 0;
  interval;
  controls = document.querySelector('.controls_container');
  rewind = document.querySelector('#rwd');
  advance = document.querySelector('#fwd');
  highlightedItems = document.getElementsByClassName('counted');
  hl_index = 0;
  testControl = document.querySelector('.go-to-test');
  options = document.getElementsByClassName('option');
  testVar = 1;
  correctAnswers = 0;
  play = document.querySelector('.play');
  // response, raw;
  console.log('initializing...');
  document.addEventListener('DOMContentLoaded', function(){ pauseAll();  assignCorrectAnswers(); /*setTimeout(function(){ advanceTextClick(); playAudio(); animateControls(); }, 1200);*/  });
  rewind.addEventListener('click', function(){rewindTextClick();}, false);
  advance.addEventListener('click', function(){advanceTextClick();}, false);
  // play.addEventListener('click', function(){ playAudio();  }, false);
  pause.addEventListener('click', function(){pauseTextClick();}, false);
}
  /* EVENT HANDLERS */
    document.addEventListener('DOMContentLoaded', function(){ pauseAll();  assignCorrectAnswers(); /*setTimeout(function(){ advanceTextClick(); playAudio(); animateControls(); }, 1200);*/  });
    rewind.addEventListener('click', function(){rewindTextClick();}, false);
    advance.addEventListener('click', function(){advanceTextClick();}, false);
    // play.addEventListener('click', function(){ playAudio();  }, false);
    pause.addEventListener('click', function(){pauseTextClick();}, false);


    /* event handlers for options */
    // for(var a = 0;0<options.length-1;a++){
    //   console.log(options.length);
    //   options[a].addEventListener('click', evaluate );
    // }


/********************************
* 1.
*********************************/
    function assignCorrectAnswers(){
      $('#question1 .o1').attr('value', 'f');
      $('#question1 .o2').attr('value', 'f');
      $('#question1 .o3').attr('value', 't');
      $('#question2 .o1').attr('value', 'f');
      $('#question2 .o2').attr('value', 't');
      $('#question2 .o3').attr('value', 'f');
      $('#question3 .o1').attr('value', 'f');
      $('#question3 .o2').attr('value', 'f');
      $('#question3 .o3').attr('value', 't');
      for(var i=0;i<options.length;i++){
        options[i].addEventListener('click', function(e){evaluate(e);});
      }
    }
/********************************
* 2.
*********************************/
      function evaluate(e){
          var val = e.target.getAttribute('value');
          console.log(val);
          $('.overlay').toggle();
          if(val=='t'){
            $('.correct').addClass('moved');
            var nextQuestion = document.querySelector('.nextQuestion');
            nextQuestion.addEventListener('click',function nq(){ $('.overlay').fadeOut(); $('overlay').toggle(); $('.evalMessage').removeClass('moved');startTest();nextQuestion.removeEventListener('click',nq);console.log(testVar);}, false);
            correctAnswers++;
            console.log(correctAnswers);
            if(correctAnswers >= 3){
              var homeButton = document.querySelector('.complete');
              $('.correct').removeClass('moved');
              $('.complete').addClass('moved');
              homeButton.addEventListener('click', function(){ location.reload(); });
            }
          }
          else{
            $('.incorrect').addClass('moved');
            var tryAgain = document.querySelector('.tryAgain');
            tryAgain.addEventListener('click',function(){ $('.overlay').fadeOut(); $('overlay').toggle(); $('.evalMessage').removeClass('moved');}, false);
          }
      }
/********************************
* 3.
  *********************************/
      function startTest(){
        $('.question').removeClass('moved').attr('style','display:none;');
        $('.video_border').fadeOut('slow');
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
        return testVar;
      }
/********************************
* 4.
*********************************/
    function rewindTextClick(){
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
          console.log( 'function name: rewindTextClick() - line 168: index = '+index);
          fwd.setAttribute('style' , 'display:inline');
          return index;
        }
      }

/********************************
* 5.
*********************************/
      function advanceTextClick(){
        console.log('function name: advanceTextClick() - line 147 animatedItemsNum is: '+animatedItemsNum);
          if( index == animatedItemsNum ){
            index = animatedItemsNum;
            fwd.setAttribute('style' , 'display:none');
            rwd.setAttribute('style' , 'display:inline');
            $(controls).append('<span onclick="startTest()" class="control go-to-test">go to test <i class="fa fa-arrow-right"></i></span> ');
            console.log('line 141: Index limit reached index reset to: '+(animatedItemsNum-1));
            return index;
          }
          else{
              if( index == 0){
                animateIn(index);
              }
              else{
                animateOut(index-1);
                animateIn(index);
                console.log( 'function name: advanceTextClick() - function #5 = '+index);
              }
              index+=1;
              rwd.setAttribute('style' , 'display:inline');
              playAudio();
              // var timeout = setTimeout( function(){highlightedItems[hl_index].className += ' highlighted'; hl_index++; return hl_index;}, 1000);
              console.log( 'function name: advanceTextClick() - line 189: index = '+index);
              return index;
          }
      }

/********************************
* 6.
*********************************/
        function playAudio(){
          var audio = document.querySelector('.audio1');
          audio.play();
          console.log('playing');
        }
/********************************
* 7.
*********************************/
        function pauseTextClick(){
            window.clearInterval(interval);
        }

/********************************
* 8.
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
* 9.
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
* 10.
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
* 11.
*********************************/
      function displayText(param){
        var lastIndex = param-1;
        console.log('function name: displayText(); line 201 - index is: '+param)
        animatedItems[lastIndex].className = 'textItem moved';
      }

/********************************
* 12.
*********************************/
        function highlightPlay(){
          $(play).addClass('highlight');
        }

/********************************
* 13.
*********************************/
        function animateControls(){
          var controls = document.querySelector('.controls_container');
          controls.className += ' moved';
          highlightPlay();
        }

/********************************
* 14.
*********************************/
          function playAudio(){
            var audio = document.querySelector('.audio_'+index);
            var audioFiles = document.getElementsByTagName('audio');
            for(var a = 0;a<audioFiles.length-1;a++){
              audioFiles[a].pause();
            }
            audio.play();
            // console.log(audio);
          }

/********************************
* 15.
*********************************/
          function pauseAudio(){
            var audio = document.querySelector('.audio_'+index);
            audio.play();
            console.log(audio);
          }

/********************************
* 16.
*********************************/
          function pauseAll(){
            var audioFiles = document.getElementsByTagName('audio');
            for(var a = 0;a<audioFiles.length-1;a++){
              audioFiles[a].pause();
            }
          }

/********************************
* 17.
*********************************/
        function controlToggle(){
          $('.play').toggle();
          $('.pause').toggle();
          $('.control').removeClass('highlight');
        }

/********************************
* 18.
*********************************/
        function resizeVideo(){
          var videoSize = document.querySelector('video');
          videoSize.clientHeight = (window.innerHeight)*(.7147);
        }
/********************************
* 19.
*********************************/
function signin(event){
  event.preventDefault();

  var username = document.querySelector('#username').value;
  var password  = document.querySelector('#password').value;
  //var response;
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
      // response = data1;
      // response.username == username
      console.log(response);
      if(response){
        $('.signIn').fadeOut('700ms');
        setTimeout(function(){ $('.signIn').remove(); advanceTextClick(); animateControls(); }, 800);
        var questionContainer = document.querySelector('.questions');
        var a = 1, b=0;
        response.questions.forEach(function(element){
          $(questionContainer).append(element.meta_value);
        });
        response.slides.forEach(function(element){
          var content = document.createTextNode(element.meta_value);
          var parser = new DOMParser();
          var parsedContent = parser.parseFromString(element.meta_value, "text/html");
          var newDiv = document.createElement('div');
          var container = document.querySelector('.presentation_text');
          console.log(parsedContent.firstChild);
          setAttributes(newDiv, {'class':'textItem', 'id':'slide-'+a});
          newDiv.appendChild(parsedContent.firstChild);
          container.appendChild(newDiv);
          a++;b++;
        });
        testInit();
        //advanceTextClick();
      }
      else{
        alert('No response. There was a database error');
      }
    },
    error:function(){
      response = 'request failed...';
    }
  });
}
/********************************
* 20.
*********************************/
function setAttributes(el, attrs){
  for(var key in attrs){
    el.setAttribute(key, attrs[key]);
  }
}
