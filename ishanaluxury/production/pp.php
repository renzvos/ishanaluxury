
<?php
session_start();
require "snippets/sidebar.php";
require "snippets/Layout.php";
require "snippets/content.php";
require "snippets/Main.php";
require "snippets/Widgets.php";
require "snippets/Head.php";
require "snippets/slider.php";
require "Db/JS.php";
require "Db/backed.php";
// require "..\..\Db\Categories.php";
require "Db/ProductsControl.php";
require "Db/CartControl.php";
require "Db/DeliveryOrderManagement.php";
require "Db/AnalyticsClient.php";

$anal = new AnalyticsClient("Privacy Policies");


$wid = new Widgets();
$OM = new Order();

$prod = new Products();

$cc = new CartControl();


if(isset($_GET["google"]))
{
	$api = new CallAPI();
	$result = json_decode($api->CallSimpleAPI("https://oauth2.googleapis.com/tokeninfo?id_token=".$_GET["google"]));
	if(!empty($result->error))
	{	if($result->error == 'invalid_token')
		{$_SESSION["gm"] = '<h5 style="color:rgba(232, 74, 74, 1);margin:10px;">Invalid Token</h5>';}
		
	}
	else
	{
		if(empty($result->email))
		{
			$_SESSION["gm"] = "Login must have an E-mail";
		}
		else
		{	$_SESSION["authenticated"]  = true;
			$_SESSION["email"] = $result->email;
			$_SESSION["name"] = $result->name;
			$_SESSION["image"] = $result->picture;
			$_SESSION["gm"] = '<h5 style="color:rgba(5, 143, 0, 1);margin:10px;">Logged in as '.$_SESSION["name"].'</h5>';
		}
	}
}


if(isset($_SESSION["authenticated"]))
{
if(is_null($cc->GetCart($_SESSION["email"])))
{$cc->CreateCart($_SESSION["email"]);}
else
{}
}


$HeadC = array();
array_push($HeadC,array('href="#"','<i class="fa fa-user"></i>',"Home",true));
if(isset($_SESSION["authenticated"])){array_push($HeadC,array('href="#"','<i class="fa fa-user"></i>',"Orders",false));}
array_push($HeadC,array('href="#"','<i class="fa fa-user"></i>',"Checkout",false));
if(isset($_SESSION["authenticated"])){array_push($HeadC,array('href="#"  onclick="ViewCart()"','<i class="fa fa-user"></i>','Cart</a>',false));}
if(!isset($_SESSION["authenticated"])){array_push($HeadC,array('href="#"','<div class="g-signin2" data-onsuccess="onSignIn" style="width:130px"></div>',"",false));}
if(isset($_SESSION["authenticated"])){array_push($HeadC,array('href="#"',$_SESSION["gm"],"",false));}


$Head = new Head('',"","fb.com","twitter.com","instagram.com","lkd.com",$HeadC);

$row1 = array('Color',array(array("Red","#"),array("Blue","#"),array("Green","#")));
$row2 = array('Sex',array(array("Male","#"),array("Female","#")));
$row3 = array('Brand',array(array("LinenClub","#"),array("Raymond","#")));

$SidebarC = array($row1,$row2,$row3);



$html = '
	 <div id="contact-page" class="container">
    	<div class="bg">
	    	<div class="row">    		
	    		<div class="col-sm-12">    			   			
					<h2 class="title text-center"> <strong>PRIVACY POLICY</strong></h2>    			    				    				
					
				</div>			 		
			</div>    	


<p style="text-align: left;"><br>Effective date: <span id="span_id_effective_date_w">December 10, 2030</span><br>Last updated on: <span id="span_id_date_of_update">December 14, 2020</span></p>

<p><strong><br>1. GENERAL</strong></p>
<p style="text-align: left; padding-left: 30px;">a. This Website with the URL of <span id="span_id_website_url">ishanaluxury.com</span> ("Website/Site") is operated by <span id="span_id_company_w">Arshad Nazir</span> ("We/Our/Us"). We are committed to protecting and respecting your privacy. We do collect your personal information and process your personal data in accordance with the IT Act, 2000 (21 of 2000) and other national and state laws which relate the processing of personal data. Please read the following carefully to understand our views and practices regarding your personal data.</p>
<p style="text-align: left; padding-left: 30px;">b. We collect your personal information in order to provide and continually improve our products and services.</p>
<p style="text-align: left; padding-left: 30px;">c. Our privacy policy is subject to change at any time without notice. To make sure you are aware of any changes, please review this policy periodically.</p>
<p style="text-align: left; padding-left: 30px;">d. All partner firms and any third-party working with or for Us, and who have access to personal information, will be expected to read and comply with this policy. </p>
<p><strong><br>2. HOW WE COLLECT THE INFORMATION</strong></p>
<p style="text-align: left; padding-left: 30px;">a. From you directly and through this Site: We may collect information through the Website when you visit. The data we collect depends on the context of your interactions with our Website.</p>
<p style="text-align: left; padding-left: 30px;">b. Through business interaction: We may collect information through business interaction with you or your employees.</p>
<p style="text-align: left; padding-left: 30px;">c. From other sources: We may receive information from other sources, such as public databases; joint marketing partners; social media platforms; or other third parties such as:</p>
<p style="text-align: left; padding-left: 60px;">I. Updated delivery and address information from our carriers or other third parties, which we use to correct our records and deliver your next purchase or communication more easily.</p>
<p style="text-align: left; padding-left: 60px;">II. Information about your interactions with the products and services offered by our subsidiaries.</p>
<p><strong><br>3. INFORMATION WE COLLECT</strong></p>
<p style="text-align: left; padding-left: 30px;">a. We collect information primarily to provide better services to all of our customers.</p>
<p style="text-align: left; padding-left: 30px;">b. We collect the following information from you when you use or signup on our Website:</p>
<p style="text-align: left; padding-left: 60px;"><span id="span_id_information_collected_w">Name and email only</span></p>

<p style="text-align: left; padding-left: 30px;">c. When you visit our Site, some information is automatically collected. This may include information such as the Operating Systems (OS) running on your device, Internet Protocol (IP) address, access times, browser type, and language, and the website you visited before our Site. We also collect information about how you use Our products or services.</p>
<p style="text-align: left; padding-left: 30px;">d. We automatically collect purchase or content use history, which we sometimes aggregate with similar information from other customers to create features such as Best Seller, Top Rated, etc...</p>
<p style="text-align: left; padding-left: 30px;">e. The full Uniform Resource Locators (URL) clickstream to, through and from our website (including date and time); cookie number; products and/or content you viewed or searched for; page response times; download errors; length of visits to certain pages; page interaction information (such as scrolling, clicks, and mouse-overs).</p>

<p style="text-align: left; padding-left: 30px;">f. By using this Website, you are agreeing that We may advertise your feedback on the Website and marketing materials.</p>
<p style="text-align: left; padding-left: 30px;">g. We will retain your information as long as we require this to provide you with the goods and services and for such period as mandated by the concerned laws.</p>
<p style="text-align: left; padding-left: 30px;">h. If you opt to receive marketing correspondence from us, subscribe to our mailing list or newsletters, enter into any of our competitions or provide us with your details at networking events, we may use your personal data for our legitimate interests in order to provide you with details about our goods, services, business updates and events.</p>
<p><strong>4. HOW WE USE INFORMATION</strong></p>
<p style="text-align: left; padding-left: 30px;">a. We use the information we collect primarily to provide, maintain, protect and improve our current products and services.</p>
<p style="text-align: left; padding-left: 30px;">b. We use the information collected through this website as described in this policy and we may use your information to:</p>
<p style="text-align: left; padding-left: 60px;">I. Improve our services, Site and how we operate our businesses;</p>
<p style="text-align: left; padding-left: 60px;">II. Understand and enhance your experience using our Site, products and services;</p>
<p style="text-align: left; padding-left: 60px;">III. Personalize our products or services and make recommendations;</p>
<p style="text-align: left; padding-left: 60px;">IV. Provide and deliver products and services you request;</p>
<p style="text-align: left; padding-left: 60px;">V. Process, manage, complete, and account for transactions;</p>
<p style="text-align: left; padding-left: 60px;">VI. Provide customer support and respond to your requests, comments, and inquiries;</p>
<p style="text-align: left; padding-left: 60px;">VII. Create and manage the online accounts you manage on our Website;</p>
<p style="text-align: left; padding-left: 60px;">VIII. Send you related information, including confirmations, invoices, technical notices, updates, security alerts and support and administrative messages;</p>
<p style="text-align: left; padding-left: 60px;">IX. Communicate with you about promotions, upcoming events and news about products and services;</p>
<p style="text-align: left; padding-left: 60px;">X. We may process your personal information without your knowledge or consent where required by applicable law or regulation for the purposes of verification of identity or for prevention, detection or investigation, including of cyber incidents, prosecution and punishment of offences;</p>
<p style="text-align: left; padding-left: 60px;">XI. Protect, investigate and deter against fraudulent, unauthorized or illegal activity.</p>
<p><strong><br>5. DATA TRANSFER</strong></p>
<p style="text-align: left; padding-left: 30px;">a. Information about our user is an important part of our business and we take due care to protect the same.</p>
<p style="text-align: left; padding-left: 30px;">b. We share your data with your consent or to complete any transaction or provide any product or service you have requested or authorized. We also share data with our affiliates and subsidiaries, with vendors working on our behalf.</p>
<p style="text-align: left; padding-left: 30px;">c. We may employ other companies and individuals to perform functions on our behalf. The functions include fulfilling orders for products or services, delivering packages, sending postal mail and e-mail, removing repetitive information from customer lists, providing marketing assistance, providing search results and links (including paid listings and links), processing payments, transmitting content, scoring credit risk, and providing customer service.</p>
<p style="text-align: left; padding-left: 30px;">d. These third-party service providers have access to personal information needed to perform their functions but may not use it for other purposes. Further, they must process the personal information in accordance with this Privacy Policy and as permitted by applicable data protection laws.</p>
<p style="text-align: left; padding-left: 30px;">e. We release account and other personal information when we believe is appropriate to comply with the law, enforce or apply our conditions of use, and other agreements, protect the rights, property or safety of Us, our users or others. This includes exchanging information with other companies and organizations for fraud protection and credit risk reduction.</p>
<p><strong><br>6. DATA SECURITY</strong></p>
<p style="text-align: left; padding-left: 30px;">a. We take due care to protect customer data. Technical measures are in place to prevent unauthorized or unlawful access to data and against accidental loss or destruction of, or damage to, data. The employees who are dealing with the data have been trained to protect the data from any illegal or unauthorized usage.</p>
<p style="text-align: left; padding-left: 30px;">b. We work to protect the security of your information during transmission by using Secure Sockets Locker (SSL) software, which encrypts information you input. SSL allows sensitive information such as credit card numbers, UID"s and login credentials to be transmitted securely. </p>
<p style="text-align: left; padding-left: 30px;">c. We maintain physical, electronic, and procedural safeguards in connection with the collection, storage, and disclosure of personal customer information.</p>
<p style="text-align: left; padding-left: 30px;">d. We take reasonable steps to help protect your personal information in an effort to prevent the loss, misuse, and unauthorized access, disclosure alteration and destruction. It is your responsibility to protect your user names and passwords to help prevent anyone from accessing or abusing your accounts and services. You should not use or reuse the same passwords you use with other accounts as your password for our services.</p>
<p style="text-align: left; padding-left: 30px;">e. It is important for you to protect against unauthorized access to your password and your computers, devices, and applications. Be sure to sign off when you finish using a shared computer.</p>
<p style="text-align: left; padding-left: 30px;">f. Information you provide to us is shared on our secure servers. We have implemented appropriate physical, technical and organizational measures designed to secure your information against accidental loss and unauthorized access, use, alteration or disclosure. In addition, we limit access to personal data to those employees, agents, contractors, and other third parties that have a legitimate business need for such access.</p>
<p style="padding-left: 30px;">g. Information collected from you will be stored for such period as required to complete the transaction entered into with you or such period as mandated under the applicable laws.</p>
<p style="text-align: left;"><strong><br>7. LINKS TO THIRD PARTY SITE/APPS</strong></p>
<p style="text-align: left; padding-left: 30px;">Our Site may, from time to time, contain links to and from other websites of third parties. Please note that if you follow a link to any of these websites, such websites will apply different terms to the collection and privacy of your personal data and we do not accept any responsibility or liability for these policies. When you leave our Site, we encourage you to read the privacy policy of every website you visit.</p>
<p><strong><br>8. SHARING OF PERSONAL INFORMATION</strong></p>
<p style="text-align: left; padding-left: 30px;">a. We do not share your personal data with third parties without your prior consent other than:</p>
<p style="text-align: left; padding-left: 60px;">I. With third parties who work on our behalf provided such third parties adhere to the data protection principles set out in the IT Act, 2000 (21 of 2000) and other applicable legislation, or enter into a written agreement with Us requiring that the third party provide at least the same level of privacy protection as is required by such principles;</p>
<p style="text-align: left; padding-left: 60px;">II. To comply with laws or to respond to lawful requests and legal process;</p>
<p style="text-align: left; padding-left: 60px;">III. To protect the rights and property of Us, our agents, customers, and others including to enforce our agreements, policies and terms of use;</p>
<p style="text-align: left; padding-left: 60px;">IV. In an emergency, including to protect the personal safety of any person; and</p>
<p style="text-align: left; padding-left: 60px;">V. For the purpose of a business deal (or negotiation of a business deal) involving the sale or transfer of all or a part of our business or assets (business deals may include, for example, any merger, financing, acquisition, divestiture or bankruptcy transaction or proceeding).</p>
<p><strong><br>9. CHILDREN</strong></p>
<p style="text-align: left; padding-left: 30px;">If you are under 18, or the age of majority in the jurisdiction in which you reside, you may only use Our Website with the consent of your parent or legal guardian. In any case, We will not be liable for any cause of action that arose due to non-compliance with this section.</p>
<p><strong><br>10. YOUR INFORMATION CHOICES AND CHANGES</strong></p>
<p style="text-align: left; padding-left: 30px;">a. You can also make choices about the collection and processing of your data by Us. You can access your personal data and opt-out of certain services provided by the Us. In some cases, your ability to control and access to your date will be subject to applicable laws.</p>
<p style="text-align: left; padding-left: 30px;">b. You may opt-out of receiving promotional emails from Us by following the instructions in those emails. If you opt-out, we may still send you non-promotional emails, such as emails about our ongoing business relationship. You may also send requests about you got preferences, changes and deletions to your information including requests to opt-out of sharing your personal information with third parties by sending an email to the email address provided at the bottom of this document.</p>

<p><br><strong>11. CHANGES TO THIS POLICY</strong></p>
<p style="text-align: left; padding-left: 30px;">We may change this policy from time to time. If we make any changes to this policy, we will change the "Last Updated" date above. You agree that your continued use of our services after such changes have been published to our services will constitute your acceptance of such revised policy. </p>
<p><strong><br>12. NEWSLETTER</strong></p>
<p style="text-align: left; padding-left: 30px;">a. Following subscription to the newsletter, your e-mail address is used for our advertising purposes until you cancel the newsletter again. Cancellation is possible at any time. The following consent has been expressly granted by you separately, or possibly in the course of an ordering process: (I am accepting to receive newsletter from this website), you may revoke your consent at any time with future effect. If you no longer want to receive the newsletter, then unsubscribe by clicking on unsubscribe option given in the email footer.</p>
<p style="text-align: left; padding-left: 30px;">If you have any concern about privacy or grievances with Us, please contact us with a thorough description and we will try to resolve the issue for you.</p>












<p style="text-align: left; padding-left: 30px;"><br><strong>Contact Details:</strong></p>
<p style="text-align: left; padding-left: 30px;"><span style="white-space:pre-wrap;"><span id="span_id_contact_details" class="encours"><span class="variable_vide">________</span></span></span></p>
					</div>

	
			</div>  
    	</div>	
    </div><!--/#contact-page-->';
	
	

$content = new Content($html);





$layout = new Layout($Head,$content);

echo $layout->Build();

	