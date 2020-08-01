// https://iro.js.org/guide.html#color-picker-events

var given = null;
var final_dist = 0.0;
var score = 0;
var end_score = 0;
var counter = 0;

//counter for colors
var direction = null; //wheel direction

var url_string = window.location.href;
var url = new URL(url_string);
var level = url.searchParams.get("level");

// alert("level: *" + level);

//timer
var time = 0;
var warning = 0;

if (level == "easy"){
  time = 23;
  warning = 18;
   // console.log(time);
}else if (level == "medium"){
  time = 15;
  warning = 12;
   // console.log(time);
}else{
  time = 6;
  warning = 3;
  // console.log(time);
}


 // if on mobile, put slider on bottom instead of right
var mq = window.matchMedia( "(min-width: 768px)" );
if (mq.matches) {
    direction = "horizontal";
}

// color picker
var colorPicker = new iro.ColorPicker('#picker', {
  width: 200,
  borderWidth: 3,
  borderColor: "#fff",
  layoutDirection: direction,
  layout: [
    { 
      component: iro.ui.Wheel,
    },
    { 
      component: iro.ui.Slider,
    },
  ]
});

// for displaying hsv, rgb, etc
// var values = document.getElementById("values");

colorPicker.on(["color:init", "color:change"], function(color){
  $("#selected").css("background-color", color.hexString);
});


// on finish
colorPicker.on("input:end", function(color){

	//parse rgb
	var rgb = color.rgbString.match(/\d+/g);
    // console.log(rgb); 

    //parse given
    var original = given.match(/\d+/g);

    //calc distance between given and selected
    var dist = distance(rgb, original);
    final_dist = dist;

    //calc score from distance
    var dub_score = ((441-final_dist)/441)*100;
    score = (Math.round(dub_score));

    // console.log("original: " + original + ", selected: " + rgb + ", distance: " + dist);
    // $("#color-score").html("Euclidean distance: " + dist);

})

// calc distance between 2 colors
distance = function(v1, v2){
        var i,d = 0;
        for (i = 0; i < v1.length; i++) {
            d += (v1[i] - v2[i])*(v1[i] - v2[i]);
        }
        return Math.sqrt(d);
};


 // generate random color
 	function getRandomColor() {
  var letters = '0123456789ABCDEF';
  var color = '#';
  for (var i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
}

//convert random color to rgb
function random_rgba() {
    var o = Math.round, r = Math.random, s = 255;
    return 'rgb(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ')';
}

//on load, set background color to random_rgba
function setRandomColor() {
	given = random_rgba();
	// alert(given);
	$("body").css("background-color", given);
}

// modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

//message displayed on modal
function message(score){
  if (score >= 98){
    return "Perfect!";
  }else if (score >= 91){
    return "Very good! Almost there!";
  }else if (score >= 85){
    return "Good, but you can still improve!";
  }else if (score >= 80){
    return "Decent, but you can do better."
  }
  else if(score >= 70){
    return "Okay :/";
  }else{
    return "Poor :("
  }
}

//first time 
$("#progressTimer").progressTimer({
    timeLimit: time,
    warningThreshold: warning,
    baseStyle: 'progress-bar bg-gray',
    warningStyle: 'progress-bar bg-black',
    completeStyle: 'progress-bar bg-black',
    onFinish: function() {
      finish(); 
    }
});

//on double click, finish round
$("html").dblclick(function() {
  finish();
});


// if next color, wait for click to trigger next round
$( "#next" ).click(function() {
  nextColor();
});

//if still rounds remaining, 
function nextColor(){
  modal.style.display = "none";
  setRandomColor();
  colorPicker.reset();
  score = 0;

  $("#progressTimer").css("display", "block");

  // clear timer
  $("#progressTimer").progressTimer({
    timeLimit: time,
    warningThreshold: warning,
    baseStyle: 'progress-bar bg-gray',
    warningStyle: 'progress-bar bg-black',
    completeStyle: 'progress-bar bg-black',
    onFinish: function() {
      finish();
    }
});
}


//on finish color, check if all rounds are over or if there are more rounds
function finish(){
  counter++; //increate # of colors displayed
  // alert("count: " + counter);

  $("#progressTimer").progressTimer({
    timeLimit: -100,
    warningThreshold: 0,
    baseStyle: 'progress-bar bg-gray',
    warningStyle: 'progress-bar bg-black',
    completeStyle: 'progress-bar bg-black',
    onFinish: function() {}
  });

    // console.log("finish called");
    modal.style.display = "block";
    $("#final_score").html(score);
    $("#msg").html(message(score));
    $("#progressTimer").css("display", "none");
    end_score += score;

    if (counter == 5){
      $("#next").html("End Game");
      $('#next').off('click');
      $( "#next" ).click(function() {
        end_game();
      });
    }

}

// if all colors cycled through, end game and display ending modal "endModal"
function end_game(){
  modal.style.display = "none";
  $("#progressTimer").css("display", "none");
  $("#ending_score").html(end_score);
  $(".endModal").css("display", "block");

  //post request to backend to store result
  sendResults(end_score, level);
}

function sendResults(scoreInput, levelInput){
  // alert("sending results");
  $.ajax({
      url: 'store_results.php',
      type: 'POST',
      data: { score: scoreInput, level: levelInput },
      success: function(output){
        // console.log(output);
      }
    });
}
