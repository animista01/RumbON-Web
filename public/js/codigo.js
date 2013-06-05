$(document).on("ready",inicio);

function inicio() {
	function changeTab (e) {
	    $("ul.nav li.active").removeClass("active");
	    $(this).addClass("active");
	    e.preventDefault();
  	}
  	$("ul.nav li").click(changeTab);
}