$(document).ready(function(){

var hiddenquestion = 'no';
var hiddenanswer = 'no';
var edit = 'no';
//toggle all questions button
$(".button-questions").click(function(){
	if (hiddenquestion === 'no') {
			$(this).children(".button-show-active").addClass("hider");
			$(".data-question").addClass("hider");
			hiddenquestion = 'yes';
		}else{
			$(this).children(".button-show-active").removeClass("hider");
			$(".data-question").removeClass("hider");
			hiddenquestion = 'no';
		}
	
		
	});
//toggle all answers button	
$(".button-answers").click(function(){
	if (hiddenanswer === 'no') {
			$(this).children(".button-show-active").addClass("hider");
			$(".data-answer").addClass("hider");
			hiddenanswer = 'yes';
		}else{
			$(this).children(".button-show-active").removeClass("hider");
			$(".data-answer").removeClass("hider");
			hiddenanswer = 'no';
		}
	
		
	});
//hover to show answers
$(".data-question").mouseenter(function() {
    if (hiddenquestion === 'yes') {
		$(this).removeClass("hider");
	}
}).mouseleave(function() {
    if (hiddenquestion === 'yes') {
		$(this).addClass("hider");
	}
});
$(".data-answer").mouseenter(function() {
    if (hiddenanswer === 'yes') {
		$(this).removeClass("hider");
	}
}).mouseleave(function() {
    if (hiddenanswer === 'yes') {
		$(this).addClass("hider");
	}
});

//functions
function additems(type){
	$.ajax({
			url: './ajax/editcard.php',
			type: 'post',
			data: {method: 'additems', type: type},
			success: function(data){
				loadtable();
			}
		});

}
function updatecard(id, type){
	$.ajax({
			url: './ajax/editcard.php',
			type: 'post',
			data: {method: 'updatecard', id: id, type: type},
			success: function(data){
				 $(".data-"+type+"[name="+id+"]").html(data);
				 $(".data-"+type+"[name="+id+"]").append("<div class='edit'></div>");
				 $(".data-"+"title").find(".data[name="+id+"]").html(data);
				 $(".data-"+"title").find(".data[name="+id+"]").append("<div class='edit'></div>");
				 $(".data-"+"heading").find(".data[name="+id+"]").html(data);
				 $(".data-"+"heading").find(".data[name="+id+"]").append("<div class='edit'></div>");
				 loadunits();
			}
		});

}
function editcard(id, value, type){
  	$.ajax({
			url: './ajax/editcard.php',
			type: 'post',
			data: {method: 'editcard', id: id, value: value, type: type},
			success: function(data){
				updatecard(id, type);
			}
		});
}
function deletecard(id){
	$.ajax({
			url: './ajax/editcard.php',
			type: 'post',
			data: {method: 'deletecard', id: id},
			success: function(data){
				loadtableafterdelete();
			}
		});
}
function upcard(id){
	$.ajax({
			url: './ajax/editcard.php',
			type: 'post',
			data: {method: 'upcard', id: id},
			success: function(data){
				loadtableafterdelete();
			}
		});
}
function downcard(id){
	$.ajax({
			url: './ajax/editcard.php',
			type: 'post',
			data: {method: 'downcard', id: id},
			success: function(data){
				loadtableafterdelete();
			}
		});
}

function loadtable(){
  	$.ajax({
			url: './ajax/editcard.php',
			type: 'post',
			data: {method: 'loadtable'},
			success: function(data){
				$('#thetable').html(data);
				window.scrollTo(0,document.body.scrollHeight);
				loadunits()
				$('html, body').scrollTop( $(document).height() );
			}
		});
}
function loadunits(){
  	$.ajax({
			url: './ajax/editcard.php',
			type: 'post',
			data: {method: 'loadunits'},
			success: function(data){
				$('#Units').html(data);
				
			}
		});
}
function loadtableafterdelete(){
  	$.ajax({
			url: './ajax/editcard.php',
			type: 'post',
			data: {method: 'loadtable'},
			success: function(data){
				$('#thetable').html(data);
				loadunits()
			}
		});
}




//edit mode
$(document).on("click", ".edit", function(){
   $(this).parent().next(".textblock").show();
    $(this).parent().hide();
  });
  
  $(document).on("click", ".savecardquestion", function(){
  	var id = $(this).next("textarea").attr("name");
   	var value = $(this).next("textarea").val();
   	var type="question";
  	editcard(id, value, "question");

    $(this).parent(".textblock").hide();
    $(this).parent(".textblock").prev(".data-question").show();
    
  });
   $(document).on("click", ".savecardanswer", function(){
   	var id = $(this).next("textarea").attr("name");
   	var value = $(this).next("textarea").val();
   	var type="answer";
  	editcard(id, value, "answer");
    $(this).parent(".textblock").hide();
    $(this).parent(".textblock").prev(".data-answer").show();
    
  });
    $(document).on("click", ".savecardanswerhead", function(){
   	var id = $(this).next("textarea").attr("name");
   	var value = $(this).next("textarea").val();
   	var type="answer";
  	editcard(id, value, "answer");
    $(this).parent(".textblock").hide();
    $(this).parent(".textblock").prev(".data").show();
    
  });
   $(document).on("click", ".deletecard", function(){
   	var id = $(this).parent(".textblock").find("textarea").attr("name");
   	var answer = confirm("Are you sure little boy?");
   	if (answer) {
   		deletecard(id);
   	}
  });
    $(document).on("click", ".upcard", function(){
   	var id = $(this).parent(".textblock").find("textarea").attr("name");
   		upcard(id);

  });
  $(document).on("click", ".downcard", function(){
   	var id = $(this).parent(".textblock").find("textarea").attr("name");
   		downcard(id);

  });

//add
$(".addTitle").on("click",  function(){
  	additems('title');
  	setTimeout(function () {
       $('html, body').scrollTop( $(document).height() );
    }, 200);
  	

  });
$(".addHead").on("click",  function(){
  	additems('header');
  	setTimeout(function () {
       $('html, body').scrollTop( $(document).height() );
    }, 200);
  });
$(".add").on("click",  function(){
  	additems('card');
  	setTimeout(function () {
       $('html, body').scrollTop( $(document).height() );
    }, 200);
  });

//highlighter
var highlighted = 0;
document.getElementById("highlighted").innerHTML = highlighted;


$(".highlight").click(function(){


$(".data-question, .data-answer").hover(function(){
$(this).toggleClass("black");
 
});

$(".data-question, .data-answer").click(function(){
$(this).toggleClass("blacker");

if($(this).hasClass("blacker")){
  highlighted += 1;
  document.getElementById("highlighted").innerHTML = highlighted;
}
else{
  highlighted -= 1;
document.getElementById("highlighted").innerHTML = highlighted;
}
});


$(this).toggleClass("highlighter");

});

//hide units
$(".UnitSelect").click(function(){
$(this).toggleClass("UnitOneUnselect");
});

$(".deselectUnit").click(function(){
$(".UnitSelect").addClass("UnitOneUnselect");
});

$(".data-wrapper").each(function(index){
index = index + 1;
$("#unit" +index ).click(function(){

$(".unit" +index ).toggleClass("HideUnit");
});

$(".deselectUnit").click(function(){
$(".unit" +index ).addClass("HideUnit");
});
});
//set  heights of each to tallest


$(document).on("keypress", "textarea",function(e) {
    if(e.which == 13) {
        var $txt = jQuery(this);
        var caretPos = $txt[0].selectionStart;
        var textAreaTxt = $txt.val();
        var txtToAdd = "<br>•";
        $txt.val(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretPos) );
    }
});

/*Settings Panel*/
	$("#closeColors").click (function () {
		$("#closeColors").fadeOut(200);
		$(".editColors").fadeOut(200);
		x = 0;
	});
	var x = 0;
	$(".openColors").click (function () {
		if (x===0){
			$("#closeColors").fadeIn(200);
			$(".editColors").fadeIn(200);
			x = 1;
		}
		else{
			$("#closeColors").fadeOut(200);
			$(".editColors").fadeOut(200);
			x = 0;
		}
		
		
	});


});

/*$(function(){
    var redHeight = $('.data-question').height();
    var brownHeight = $('.data-answer').height();
    
    if (redHeight > brownHeight){
        $('.data-answer').css('height', redHeight );
    }
    else{
        $('.data-question').css('height', brownHeight);
    }
});*/



