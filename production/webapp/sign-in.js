
function RemoveCart(email,id)
{
const Http = new XMLHttpRequest();
//const url= "http://www.ishanaluxury.com/api/RemoveFromCart.php?email='.$_SESSION["email"].'&q=1&delid=" + id;
Http.open("GET", url);
Http.send();
Http.onreadystatechange = (e) => {
ModelChange(Http.responseText);
}

}

function ChangeQuantity(email,id,q)
{
const Http = new XMLHttpRequest();
//const url= "http://www.ishanaluxury.com/api/changeq.php?email='.$_SESSION["email"].'&q=" + q + "&id=" + id;
Http.open("GET", url);
Http.send();
Http.onreadystatechange = (e) => {
ModelChange(Http.responseText);
}
}

function AddtoCart(id,q)
{
const Http = new XMLHttpRequest();
//const url= "http://www.ishanaluxury.com/api/addtoCart.php?email='.$_SESSION["email"].'&q=" + q + "&pid=" + id;
Http.open("GET", url);
Http.send();
Http.onreadystatechange = (e) => {
ModelOpen("Cart",Http.responseText,
"<button class=\"btn btn-default get pull-right\" type=\"button\" style=\"padding: 20px;margin: 20px;\"><a href = \"checkout.php\">Proceed to Checkout</a> </button>");
	}
}

function ViewCart()
{
	const Http = new XMLHttpRequest();
	//const url= "http://www.ishanaluxury.com/api/viewCart.php?email='.$_SESSION["email"].'";
	Http.open("GET", url);
	Http.send();
	Http.onreadystatechange = (e) => {
	ModelOpen("Cart",Http.responseText,
			"<button class=\"btn btn-default get pull-right\" type=\"button\" style=\"padding: 20px;margin: 20px;\"><a href = \"checkout.php\">Proceed to Checkout</a> </button>");
		}

}

alert("OK");

