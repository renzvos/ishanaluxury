
<?php
session_start();
require "snippets/sidebar.php";
require "snippets/Layout.php";
require "snippets/content.php";
require "snippets/Main.php";
require "snippets/Widgets.php";
require "snippets/Head.php";
require "snippets/slider.php";
require "Db/backed.php";
require "Db/JS.php";
// require "..\..\Db\Categories.php";
require "Db/ProductsControl.php";
require "Db/CartControl.php";
require "Db/DeliveryOrderManagement.php";
require "Db/AnalyticsClient.php";

$anal = new AnalyticsClient("TermsAndConditions");


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
					<h2 class="title text-center"> <strong>TERMS AND CONDITIONS</strong></h2>    			    				    				
					
				</div>			 		
			</div>    	
    		
<p><br>Effective Date: <span id="span_id_effective_date">December 14, 2020</span></p>
<p><em>Website Covered: <span id="span_id_name_of_site_covered">www.ishanaluxury.com</span></em></p>
<p><strong>THE AGREEMENT:</strong> The use of this website and services on this website provided by  <span id="span_id_company_name">RENZVOS</span>  (hereinafter referred to as "<strong>Owner</strong>") are subject to the following Terms &amp; Conditions (hereinafter the "<strong>Terms of Service</strong>"), all parts and sub-parts of which are specifically incorporated by reference here. Following are the Terms of Service governing your use of <em><span id="span_id_name_of_site_covered">www.ishanaluxury.com</span></em> (the "<strong>Website</strong>"), all pages on the Website and any services provided by or on this Website ("<strong>Services</strong>").</p>
<p>By accessing either directly or through a hyperlink, the Website, and/ or purchasing something from us, you engage in our "Service" and agree to be bound by the Terms of Service including those additional terms and conditions and policies referenced herein and/or available by hyperlink. These Terms of Service apply to all users of the site, including without limitation vendors, buyers, customers, merchants, browsers and/ or contributors of content. </p>
<p><strong><br>1) DEFINITIONS</strong></p>
<p>The parties referred to in these Terms of Service shall be defined as follows:</p>
<p>a) Owner, Us, We: The Owner, as the creator, operator, and publisher of the Website, makes the Website, and certain Services on it, available to users.  <span id="span_id_company_name">RENZVOS</span>, Owner, Us, We, Our, Ours and other first-person pronouns will refer to the Owner, as well as all employees and affiliates of the Owner.</p>
<p>b) You, the User, the Client: You, as the user of the Website, will be referred to throughout these Terms of Service with second-person pronouns such as You, Your, Yours, or as User or Client. For the purpose of these Terms of Service, the term "<strong>User</strong>" or "<strong>you</strong>" shall mean any natural or legal person who person is accessing the Website. The term "<strong>Your</strong> shall be construed accordingly.</p>
<p>c) Parties: Collectively, the parties to these Terms of Service (the Owner and You) will be referred to as Parties.</p>
<p><strong><br>2) ASSENT &amp; ACCEPTANCE</strong></p>
<p>By using the Website, You warrant that You have read and reviewed these Terms of Service and that You agree to be bound by it. If You do not agree to be bound by these Terms of Service, please leave the Website immediately. The Owner only agrees to provide use of this Website and Services to You if You assent to these Terms of Service. Further, based on the Services obtained by a User, additional terms and conditions in respect of the specific Services may apply, which shall be deemed an agreement between the Users and the Owner.</p>
<p><strong><br>3) ABOUT THE SITE</strong> </p>
<p>The Website is an online store which carries out sale of the following: <span id="span_id_describe_products"><span class="variable_vide">________</span></span>. We reserve the right to refuse service or refuse to sell the products on the Website at our sole discretion to anyone for any reason at any time.</p>
<p>The Website does not screen or censor the users who register on and access the Website. You assume all risks associated with dealing with other users with whom you come in contact through the Website. You agree to use the Website only for lawful purposes without infringing the rights or restricting the use of this Website by any third party.</p>
<p><strong><br>4) LICENSE TO USE WEBSITE</strong></p>
<p>The Owner may provide You with certain information as a result of Your use of the Website or Services. Such information may include but is not limited to, documentation, data, or information developed by the Owner, and other materials which may assist in Your use of the Website or Services ("Owner Materials"). Subject to these Terms of Service, the Owner grants You a non-exclusive, limited, non-transferable and revocable license to use the Owner Materials solely in connection with Your use of the Website and Services. The Owner Materials may not be used for any other purpose and this license terminates upon Your cessation of use of the Website or Services or at the termination of these Terms of Service.</p>
<p>You agree not to collect contact information of other Users from the Website or download or copy any information by means of unsolicited access so as to communicate directly with them or for any reason whatsoever.</p>
<p>Any unauthorized use by you shall terminate the permission or license granted to you by the Website and You agree that you shall not bypass any measures used by the Owner to prevent or restrict access to the Website.</p>
<p><strong><br>5) INTELLECTUAL PROPERTY</strong></p>
<p>You agree that the Website and all Services provided by the Owner are the property of the Owner, including all copyrights, trademarks, trade secrets, patents and other intellectual property ("Owner IP"). You agree that the Owner owns all right, title and interest in and to the Owner IP and that You will not use the Owner IP for any unlawful or infringing purpose. You agree not to reproduce or distribute the Owner IP in any way, including electronically or via registration of any new trademarks, trade names, service marks or Uniform Resource Locators (URLs), without express written permission from the Owner.</p>

<p><strong><br>6) USER OBLIGATIONS</strong></p>
<p>As a user of the Website or Services, You may be asked to register with Us. When You do so, You will choose a user identifier, which may be Your email address or another term, as well as a password. You may also provide personal information, including, but not limited to, Your name. You are responsible for ensuring the accuracy of this information. This identifying information will enable You to use the Website and Services. You must not share such identifying information with any third party and if You discover that Your identifying information has been compromised, You agree to notify Us immediately in writing. An email notification will suffice. You are responsible for maintaining the safety and security of Your identifying information as well as keeping Us apprised of any changes to Your identifying information. The billing information You provide us, including credit card, billing address and other payment information, is subject to the same confidentiality and accuracy requirements as the rest of Your identifying information. Providing false or inaccurate information, or using the Website or Services to further fraud or unlawful activity is grounds for immediate termination of these Terms of Service. The Owner reserves the right to refuse service, terminate accounts, or remove or edit content in its sole discretion.</p>
<p><strong><br>7) PAYMENT &amp; FEES</strong></p>
<p>Should You register for any of the paid Services on this website or purchase any product or service on this website, You agree to pay Us the specific monetary amounts required for that product or those Services. These monetary amounts ("Fees") will be described to You during Your account registration and/or confirmation process. The final amount required for payment will be shown to You immediately prior to purchase. </p>
<p>We reserve the right to refuse service or refuse to sell the products on the Website at our sole discretion to anyone for any reason at any time.</p>
<p><strong><br>8) ACCEPTABLE USE</strong></p>
<p>You agree not to use the Website or Services for any unlawful purpose or any purpose prohibited under this clause. You agree not to use the Website or Services in any way that could damage the Website, Services or general business of the Owner.</p>
<p>a) You further agree not to use the Website or Services:</p>
<p>I) To harass, abuse, or threaten others or otherwise violate any persons legal rights;</p>
<p>II) To violate any intellectual property rights of the Owner or any third party;</p>
<p>III) To upload or otherwise disseminate any computer viruses or other software that may damage the property of another;</p>
<p>IV) To perpetrate any fraud;</p>
<p>V) To engage in or create any unlawful gambling, sweepstakes, or pyramid scheme;</p>
<p>VI) To publish or distribute any obscene or defamatory material;</p>
<p>VII) To publish or distribute any material that incites violence, hate or discrimination towards any group;</p>
<p>VIII) To unlawfully gather information about others.</p>
<p>You are prohibited from using the site or its content: (a) for any unlawful purpose; (b) to solicit others to perform or participate in any unlawful acts; (c) to infringe on any third party intellectual property or proprietary rights, or rights of publicity or privacy, whether knowingly or unknowingly; (d) to violate any local, federal or international law, statute, ordinance or regulation; ((e) to harass, abuse, insult, harm, defame, slander, disparage, intimidate, or discriminate based on gender, sexual orientation, religion, ethnicity, race, age, national origin, or disability; (f) to submit false or misleading information or any content which is defamatory, libelous, threatening, unlawful, harassing, indecent, abusive, obscene, or lewd and lascivious or pornographic, or exploits minors in any way or assists in human trafficking or content that would violate rights of publicity and/or privacy or that would violate any law; (g) to upload or transmit viruses or any other type of malicious code that will or may be used in any way that will affect the functionality or operation of the Service or of any related website, other websites, or the Internet; (h) to collect or track the personal information of others; (i) to damage, disable, overburden, or impair the Website or any other partys use of the Website; (j) to spam, phish, pharm, pretext, spider, crawl, or scrape; (j) for any obscene or immoral purpose; or (k) to interfere with or circumvent the security features of the Service or any related website, other websites, or the Internet; (l) to personally threaten or has the effect of personally threatening other Users. We reserve the right to terminate your use of the Service or any related website for violating any of the prohibited uses. The Company has the full authority to review all content posted by Users on the Website. You acknowledge that the Website is not responsible or liable and does not control the content of any information that may be posted to the Website by You or other User of the Website and you are solely responsible for the same. You agree that You shall not upload, post, or transmit any content that you do not have a right to make available (such as, the intellectual property of another party).</p>
<p>You agree to comply with all applicable laws, statutes and regulations concerning your use of the Website and further agree that you will not transmit any information, data, text, files, links, software, chats, communication or other materials that are abusive, invasive of anothers privacy, harassing, defamatory, vulgar, obscene, unlawful, false, misleading, harmful, threatening, hateful or racially or otherwise objectionable, including without limitation material of any kind or nature that encourages conduct that could constitute a criminal offence, give rise to civil liability or otherwise violate any applicable local, state, provincial, national, or international law or regulation, or encourage the use of controlled substances.</p>
<p>We may, but have no obligation to, monitor, edit or remove content that we determine in our sole discretion are unlawful, offensive, threatening, libellous, defamatory, pornographic, obscene or otherwise objectionable or violates any party"s intellectual property or these Terms of Service.</p>
<p>You may not use our products for any illegal or unauthorized purpose nor may you, in the use of the Service, violate any laws in your jurisdiction (including but not limited to copyright laws).</p>
<p><strong><br>9) COMMUNICATION</strong></p>
<p>You understand that each time uses the Website in any manner, you agree to these Terms. By agreeing to these Terms, you acknowledge that you are interested in availing and purchasing the Services that you have selected and consent to receive communications via phone or electronic records from the Website including e-mail messages telling you about products and services offered by the Website (or its affiliates and partners) and understanding your requirements. Communication can also be by posting any notices on the Website. You agree that the communications sent to You by the Website shall not be construed as spam or bulk under any law prevailing in any country where such communication is received.</p>
<p><strong><br>10) PRIVACY INFORMATION</strong></p>
<p>Through Your Use of the Website and Services, You may provide Us with certain information. By using the Website or the Services, You authorize the Owner to use Your information in India and any other country where We may operate.</p>
<p>a) Information We May Collect or Receive: When You register for an account, You provide Us with a valid email address and may provide Us with additional information, such as Your name or billing information. Depending on how You use Our Website or Services, We may also receive information from external applications You use to access Our Website, or We may receive information through various web technologies, such as cookies, log files, clear gifs, web beacons or others.</p>
<p>b) How We Use Information: We use the information gathered from You to ensure Your continued good experience on Our website, including through email communication. We may also track certain of the passive information received to improve Our marketing and analytics, and for this, We may work with third-party providers.</p>
<p>c) How You Can Protect Your Information: If You would like to disable Our access to any passive information We receive from the use of various technologies, You may choose to disable cookies in Your web browser. Please be aware that the Owner will still receive information about You that You have provided, such as Your email address. If You choose to terminate Your account, the Owner may store some information about You for the future reference. </p>
<p><strong><br>11) ASSUMPTION OF RISK</strong></p>
<p>The Website and Services are provided for communication purposes only. You acknowledge and agree that any information posted on Our Website is not intended to be legal advice, medical advice, or financial advice, and no fiduciary relationship has been created between You and the Owner. You further agree that Your purchase of any of the products on the Website is at Your own risk. The Owner does not assume responsibility or liability for any advice or other information given on the Website.</p>
<p><strong><br>12) SALE OF GOODS/SERVICES</strong></p>
<p>The Owner may sell goods or services or allow third parties to sell goods or services on the Website. The Owner undertakes to be as accurate as possible with all information regarding the goods and services, including product descriptions and images. However, the Owner does not guarantee the accuracy or reliability of any product information and You acknowledge and agree that You purchase such products at Your own risk. </p>
<p><strong><br>13) SHIPPING/DELIVERY/RETURN POLICY</strong></p>
<p>You agree to ensure payment for any items You may purchase from Us and You acknowledge and affirm that prices are subject to change. When purchasing a physical good, You agree to provide Us with a valid email and shipping address, as well as valid billing information. We reserve the right to reject or cancel an order for any reason, including errors or omissions in the information You provide to us. If We do so after payment has been processed, We will issue a refund to You in the amount of the purchase price. We also may request additional information from You prior to confirming a sale and We reserve the right to place any additional restrictions on the sale of any of Our products. You agree to ensure payment for any items You may purchase from Us and You acknowledge and affirm that prices are subject to change. For the sale of physical products, We may preauthorize Your credit or debit card at the time You place the order or We may simply charge Your card upon shipment. You agree to monitor Your method of payment. Shipment costs and dates are subject to change from the costs and dates You are quoted due to unforeseen circumstances. For any questions, concerns, or disputes, You agree to contact Us in a timely manner at the following: <span id="span_id_email_address_of_client"><span class="variable_vide">________</span></span>. </p>
<p>We will make reimbursements for returns without undue delay, and not later than:</p>
<p>(i) 30 days after the day we received back from you any goods supplied; or</p>
<p>(ii) (if earlier) 30 days after the day you provide evidence that you have returned the goods; or</p>
<p>(iii) if there were no goods supplied, 30 days after the day on which we are informed about your decision to cancel this contract.</p>
<p>We will make the reimbursement using the same means of payment as you used for the initial transaction unless you have expressly agreed otherwise; in any event, you will not incur any fees as a result of the reimbursement.</p>
<p><strong><br>14) REVERSE ENGINEERING &amp; SECURITY</strong></p>
<p>You agree not to undertake any of the following actions:</p>
<p>a) Reverse engineer, or attempt to reverse engineer or disassemble any code or software from or on the Website or Services;</p>
<p>b) Violate the security of the Website or Services through any unauthorized access, circumvention of encryption or other security tools, data mining or interference to any host, user or network.</p>
<p><strong><br>15) DATA LOSS</strong></p>
<p>The Owner does not accept responsibility for the security of Your account or content. You agree that Your use of the Website or Services is at Your own risk.</p>
<p><strong><br>16) INDEMNIFICATION</strong></p>
<p>You agree to defend and indemnify the Owner and any of its affiliates (if applicable) and hold Us harmless against any and all legal claims and demands, including reasonable attorney"s fees, which may arise from or relate to Your use or misuse of the Website or Services, Your breach of these Terms of Service, or Your conduct or actions. You agree that the Owner shall be able to select its own legal counsel and may participate in its own defence if the Owner wishes.</p>
<p><strong><br>17) SPAM POLICY</strong></p>
<p>You are strictly prohibited from using the Website or any of the Owner"s Services for illegal spam activities, including gathering email addresses and personal information from others or sending any mass commercial emails.</p>
<p><strong><br>18) THIRD-PARTY LINKS &amp; CONTENT</strong></p>
<p>The Owner may occasionally post links to third-party websites or other services. You agree that the Owner is not responsible or liable for any loss or damage caused as a result of Your use of any third party services linked to from Our Website.</p>
<p><strong><br>19) MODIFICATION &amp; VARIATION</strong></p>
<p>The Owner may, from time to time and at any time without notice to You, modify these Terms of Service. You agree that the Owner has the right to modify these Terms of Service or revise anything contained herein. You further agree that all modifications to these Terms of Service are in full force and effect immediately upon posting on the Website and that modifications or variations will replace any prior version of these Terms of Service unless prior versions are specifically referred to or incorporated into the latest modification or variation of these Terms of Service.</p>
<p>a) To the extent any part or sub-part of these Terms of Service is held ineffective or invalid by any court of law, You agree that the prior, effective version of these Terms of Service shall be considered enforceable and valid to the fullest extent.</p>
<p>b) You agree to routinely monitor these Terms of Service and refer to the Effective Date posted at the top of these Terms of Service to note modifications or variations. You further agree to clear Your cache when doing so to avoid accessing a prior version of these Terms of Service. You agree that Your continued use of the Website after any modifications to these Terms of Service is a manifestation of Your continued assent to these Terms of Service.</p>
<p>c) In the event that You fail to monitor any modifications to or variations of these Terms of Service, You agree that such failure shall be considered an affirmative waiver of Your right to review the modified Agreement.</p>
<p><strong><br>20) ENTIRE AGREEMENT</strong></p>
<p>This Agreement constitutes the entire understanding between the Parties with respect to any and all use of this Website. This Agreement supersedes and replaces all prior or contemporaneous agreements or understandings, written or oral, regarding the use of this Website.</p>
<p><strong><br>21) SERVICE INTERRUPTIONS</strong></p>
<p>The Owner may need to interrupt Your access to the Website to perform maintenance or emergency services on a scheduled or unscheduled basis. You agree that Your access to the Website may be affected by unanticipated or unscheduled downtime, for any reason, but that the Owner shall have no liability for any damage or loss caused as a result of such downtime.</p>
<p><strong><br>22) TERM, TERMINATION &amp; SUSPENSION</strong></p>
<p>The Owner may terminate these Terms of Service with You at any time for any reason, with or without cause. The Owner specifically reserves the right to terminate these Terms of Service if You violate any of the terms outlined herein, including, but not limited to, violating the intellectual property rights of the Owner or a third party, failing to comply with applicable laws or other legal obligations, and/or publishing or distributing illegal material. If You have registered for an account with Us, You may also terminate these Terms of Service at any time by contacting Us and requesting termination. Please keep in mind that any outstanding fees will still be due even after termination of Your account. At the termination of these Terms of Service, any provisions that would be expected to survive termination by their nature shall remain in full force and effect.</p>
<p><strong><br>23) NO WARRANTIES</strong></p>
<p>You agree that Your use of the Website and Services is at Your sole and exclusive risk and that any Services provided by Us are on an "As Is" basis. The Owner hereby expressly disclaims any and all express or implied warranties of any kind, including, but not limited to the implied warranty of fitness for a particular purpose and the implied warranty of merchantability. The Owner makes no warranties that the Website or Services will meet Your needs or that the Website or Services will be uninterrupted, error-free, or secure. The Owner also makes no warranties as to the reliability or accuracy of any information on the Website or obtained through the Services. You agree that any damage that may occur to You, through Your computer system, or as a result of the loss of Your data from Your use of the Website or Services is Your sole responsibility and that the Owner is not liable for any such damage or loss.</p>
<p>All information, software, products, services and related graphics are provided on this site is "as is" and "as available" basis with without warranty of any kind, either expressed or implied. The Website disclaims all warranties, expressed or implied including, without limitation, all implied warranties of merchantability, fitness for a particular purpose, title and non-infringement or arising from a course of dealing, usage, or trade practice. The company makes no representation about the suitability of the information, software, products, and services contained on this Website for any purpose, and the inclusion or offering of any products or services on this Website does not constitute any endorsement or recommendation of such products or services.</p>
<p>The Website makes no warranty that the use of the Website will be uninterrupted, timely, secure, without defect or error-free. You expressly agree that use of the site is at your own risk. The Website shall not be responsible for any content found on the Website.</p>
<p>Your use of any information or materials on this site or otherwise obtained through use of this Website is entirely at your own risk, for which we shall not be liable. It shall be your own responsibility to ensure that any products, services or information available through this website meet your specific requirements.</p>
<p>The Website assumes no responsibility for the accuracy, currency, completeness or usefulness of information, views, opinions or advice in any material contained on the Website. Any information of third parties or advertisers is made available without doing any changes and so the Website cannot guarantee accuracy and is not liable to any inconsistencies arising thereof. All postings, messages, advertisements, photos, sounds, images, text, files, video or other materials posted on, transmitted through, or linked from the Website, are solely the responsibility of the person from whom such Content originated and the Website does not control and is not responsible for Content available on the Website.</p>
<p>There may be instances when incorrect information is published inadvertently on our Website or in the Service such as typographical errors, inaccuracies or omissions that may relate to product descriptions, pricing, promotions, offers, product shipping charges, transit times and availability. Any errors, inaccuracies or omissions, may be corrected at our discretion at any time and we may change or update information or cancel orders if any information in the Service or on any related website is inaccurate at any time without prior notice (including after you have submitted your order).</p>
<p>We undertake no obligation to update, amend or clarify information in the Service or on any related website, including without limitation, pricing information, except as required by law. No specified update or refresh date applied in the Service or on any related website should be taken to indicate that all information in the Service or on any related website has been modified or updated.</p>
<p>The Website shall not be responsible for any interaction between you and the other users of the Website. Under no circumstances will the Website be liable for any goods, services, resources or content available through such third party dealings or communications, or for any harm related thereto. The Website is under no obligation to become involved in any disputes between you and other users of the Website or between you and any other third parties. You agree to release the Website from any and all claims, demands, and damages arising out of or in connection with such dispute.</p>
<p>You agree and understand that while the Website has made reasonable efforts to safeguard the Website, it cannot and does not ensure or make any representations that the Website or any of the information provided by You cannot be hacked by any unauthorised third parties. You specifically agree that the Website shall not be responsible for unauthorized access to or alteration of Your transmissions or data, any material or data sent or received or not sent or received, or any transactions entered into through the Website.</p>
<p>You hereby agree and confirm that the Website shall not be held liable or responsible in any manner whatsoever for such hacking or any loss or damages suffered by you due to unauthorized access of the Website by third parties or for any such use of the information provided by You or any spam messages or information that You may receive from any such unauthorised third party (including those which are although sent representing the name of the Website but have not been authorized by the Website) which is in violation or contravention of this Terms of Service or the Privacy Policy.</p>
<p>You specifically agree that the Website is not responsible or liable for any threatening, defamatory, obscene, offensive or illegal content or conduct of any other party or any infringement of another"s rights, including intellectual property rights. You specifically agree that the Website is not responsible for any content sent using and/or included in the Website by any third party.</p>
<p>The Website has no liability and will make no refund in the event of any delay, cancellation, strike, force majeure or other causes beyond their direct control, and they have no responsibility for any additional expense omissions delays or acts of any government or authority.</p>
<p>You will be solely responsible for any damages to your computer system or loss of data that results from the download of any information and/or material. Some jurisdictions do not allow the exclusion of certain warranties, so some of the above exclusions may not apply to you.</p>
<p>In no event shall the Website be liable for any direct, indirect, punitive, incidental, special, consequential damages or any damages whatsoever including, without limitation, damages for loss of use, data or profits, arising out of or in any way connected with the use or performance of the site, with the delay or inability to use the site or related services, the provision of or failure to provide Services, or to deliver the products or for any information, software, products, services and related graphics obtained through the site, or any interaction between you and other participants of the Website or otherwise arising out of the use of the Website, damages resulting from use of or reliance on the information present, whether based on contract, tort, negligence, strict liability or otherwise, even if the Website or any of its affiliates/suppliers has been advised of the possibility of damages. If despite the limitation above, the Company is found liable for any loss or damage which arises out of or in any way connected with the use of the Website and/ or provision of Services, then the liability of the Company will in no event exceed, 50% (Fifty percent) of the amount you paid to the Company in connection with such transaction(s) on this Website.</p>
<p>You accept all responsibility for and hereby agree to indemnify and hold harmless the company from and against, any actions taken by you or by any person authorized to use your account, including without limitation, disclosure of passwords to third parties. By using the Website, you agree to defend, indemnify and hold harmless the indemnified parties from any and all liability regarding your use of the site or participation in any site"s activities. If you are dissatisfied with the Website, or the Services or any portion thereof, or do not agree with these terms, your only recourse and exclusive remedy shall be to stop using the site.</p>
<p><strong><br>24) LIMITATION ON LIABILITY</strong></p>
<p>The Owner is not liable for any damages that may occur to You as a result of Your use of the Website or Services, to the fullest extent permitted by law. The maximum liability of the Owner arising from or relating to these Terms of Service 
<p><strong><br>25) GENERAL PROVISIONS:</strong></p>
<p><strong>a) LANGUAGE:</strong> All communications made or notices given pursuant to these Terms of Service shall be in the English language.</p>
<p><strong>b) JURISDICTION, VENUE &amp; GOVERNING LAW:</strong> Through Your use of the Website or Services, You agree that the laws of India shall govern any matter or dispute relating to or arising out of these Terms of Service, as well as any dispute of any kind that may arise between You and the Owner, with the exception of its conflict of law provisions. In case any litigation specifically permitted under these Terms of Service is initiated, the Parties agree to submit to the exclusive jurisdiction of the courts at <span id="span_id_courtsplace" class="encours"><span class="variable_vide">________</span></span>, India. The Parties agree that this choice of law, venue, and jurisdiction provision is not permissive, but rather mandatory in nature. You hereby waive the right to any objection of venue, including assertion of the doctrine of forum non-conveniens or similar doctrine.</p>
<p><strong>d) SEVERABILITY:</strong> If any part or sub-part of these Terms of Service is held invalid or unenforceable by a court of law or competent arbitrator, the remaining parts and sub-parts will be enforced to the maximum extent possible. In such condition, the remainder of these Terms of Service shall continue in full force.</p>
<p><strong>e) NO WAIVER:</strong> In the event that We fail to enforce any provision of these Terms of Service, this shall not constitute a waiver of any future enforcement of that provision or of any other provision. Waiver of any part or sub-part of these Terms of Service will not constitute a waiver of any other part or sub-part.</p>
<p><strong>f) HEADINGS FOR CONVENIENCE ONLY:</strong> Headings of parts and sub-parts under these Terms of Service are for convenience and organization, only. Headings shall not affect the meaning of any provisions of these Terms of Service.</p>
<p><strong>g) NO AGENCY, PARTNERSHIP OR JOINT VENTURE:</strong> No agency, partnership, or joint venture has been created between the Parties as a result of these Terms of Service. No Party has any authority to bind the other to third parties.</p>
<p><strong>i) ELECTRONIC COMMUNICATIONS PERMITTED:</strong> Electronic communications are permitted to both Parties under these Terms of Service, including e-mail or fax. For any questions or concerns, please email Us at the following address: <span id="span_id_email_address_of_client"><span class="variable_vide">________</span></span>.</p>					</div>
			
			</div>  
    	</div>	
    </div><!--/#contact-page-->';
	
	

$content = new Content($html);





$layout = new Layout($Head,$content);

echo $layout->Build();

	