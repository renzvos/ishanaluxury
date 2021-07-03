//alert("onload");

var modal = document.getElementById("MODELER");

var span = document.getElementsByClassName("mclose")[0];


// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
  var uparrow = document.getElementById("scrollUp");
  uparrow.style.display = "block";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
	var uparrow = document.getElementById("scrollUp");
	uparrow.style.display = "block";
  }
}



function SignInFirst()
{ 
								const scrollToTop = () => {
				const c = document.documentElement.scrollTop || document.body.scrollTop;
  if (c > 0) {
    window.requestAnimationFrame(scrollToTop);
    window.scrollTo(0, c - c / 8);
  }
};
scrollToTop();
ModelOpen("Sign in to Continue","","");


}

	function Search()
	{
		key = document.getElementById("search").value;
		window.location.href = "shop.php?key="+key;
	}



						
						




