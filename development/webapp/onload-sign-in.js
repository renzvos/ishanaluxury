//alert("onload sign in ");

function RemoveCart(email,id)
{
const Http = new XMLHttpRequest();
const url= selfapi + "RemoveFromCart.php?email=" + email + "&q=1&delid=" + id;
Http.open("GET", url);
Http.send();
Http.onreadystatechange = (e) => {
ModelChange(Http.responseText);
}

}

function ChangeQuantity(email,id,q)
{
const Http = new XMLHttpRequest();
const url= selfapi + "changeq.php?email=" + email + "&q=" + q + "&id=" + id;
Http.open("GET", url);
Http.send();
Http.onreadystatechange = (e) => {
ModelChange(Http.responseText);
}
}

function AddtoCart(id,q)
{
const Http = new XMLHttpRequest();
const url= selfapi + "addtoCart.php?email=" + email + "&q=" + q + "&pid=" + id;
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
	const url = selfapi + "viewCart.php?email=" + email;
	Http.open("GET", url);
	Http.send();
	Http.onreadystatechange = (e) => {
	ModelOpen("Cart",Http.responseText,
			"<button class=\"btn btn-default get pull-right\" type=\"button\" style=\"padding: 20px;margin: 20px;\"><a href = \"checkout.php\">Proceed to Checkout</a> </button>");
		}

}



