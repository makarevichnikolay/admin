$(document).ready(function(){
	$(".answer").hide();
	$("#hide_answers").hide();

	$("#show_answers").click(function() {
		$(".answer").show();
		$("#hide_answers").show();
		$(".show_answer").hide();
	});

	$("#hide_answers").click(function() {
		$(".answer").hide();
		$("#hide_answers").hide();
		$(".show_answer").show();
	});

	$(".show_answer").click(function() {
		var array;
		array = this.id.split('-');
		$(this).hide();
		$("#hide_answers").show();
		$("#answer-"+array[1]).show();
	});


});