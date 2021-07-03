

	<div id="MODELER" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="mclose">&times;</span>
	  <div class="mtt">
      <h2>Cart</h2>
	  </div>
    </div>
    <div class="modal-body" style="max-height: 350px;overflow: auto;">
      <p>Some text in the Modal Body</p>
      <p>Some other text...</p>
    </div>
    <div class="modal-footer">
      <h3>Modal Footer</h3>
    </div>
  </div>

</div>

<script>

var modal = document.getElementById("MODELER");

function ModelOpen(Header,Content,Footer)
{   
	document.getElementsByClassName("mtt")[0].innerHTML = "<h2>" +  Header + "</h2>";
	document.getElementsByClassName("modal-body")[0].innerHTML = Content;
	document.getElementsByClassName("modal-footer")[0].innerHTML = Footer;
	modal.style.display = "block";
	var uparrow = document.getElementById("scrollUp");
	uparrow.style.display = "none";
}


function ModelChange(Content)
{
	document.getElementsByClassName("modal-body")[0].innerHTML = Content;
	if(document.getElementById("cartcontent") !== null){document.getElementById("cartcontent").innerHTML = Content;}
}

</script>