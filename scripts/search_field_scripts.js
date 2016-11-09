var myapp = angular.module("myapp",[]);

myapp.controller("newController", function($scope,$http){
	$http.get("lib/dynamoDB/search.php").success(function(response){
		$scope.users = response;
	});
	$scope.num = 5;
});

$("#search").keyup(function(e) {
	if (e.keyCode == 27) {
		$('#output').css("visibility", "hidden");
		$('#search_result_view').css("zIndex", "0");
		$('#search').blur();
	}
});

var sFocus = false;
var oFocus = false;

$("#search").click(function(e) {
	sFocus = true;
	check();
});

$('#search').blur(function() {
	sFocus = false;
});

function check(){
	var search = document.forms["myForm"]["search"].value;
	if(search) {
		document.getElementById('output').style.visibility = "visible";
		document.getElementById("search_result_view").style.zIndex = "10";
	} else {
		document.getElementById('output').style.visibility = "hidden";
		document.getElementById("search_result_view").style.zIndex = "0";
	}
}

//if user click one from search output, set last_tab to #accounts to display accounts from in customer.php page
function oneSearchResult() {
	oFocus = true;
	$.cookie('last_tab', '#account');
};

$(window).click(function() {
	if(sFocus == false && oFocus == false) {
		$('#output').css("visibility", "hidden");
		$('#search_result_view').css("zIndex", "0");
	}
});
		
function getSearch(){
	if($.cookie('last_tab') == "#") {
		if($('#accounts_tab').hasClass("active")) {
			
		} else {
			$('#accounts_tab').addClass("active");
			$('#supports_tab').removeClass("active")
			$("#tickets_display").addClass('hidden');
			$("#support_display").addClass('hidden');
			$("#accounts_display").removeClass('hidden');
		}
	} else {
		var search = document.forms["myForm"]["search"].value;
		window.location.href = "summary?f="+search;
	}
}