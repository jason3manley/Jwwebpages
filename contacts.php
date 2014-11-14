

<?php

// Set email variables
$email_to = 'jw@jwwebpages.com';
$email_subject = 'Form submission';

// Set required fields
$required_fields = array('fullname','email','comment');

// set error messages
$error_messages = array(
	'fullname' => 'Please enter a Name to proceed.',
	'email' => 'Please enter a valid Email Address to continue.',
	'comment' => 'Please enter your Message to continue.'
);

// Set form status
$form_complete = FALSE;

// configure validation array
$validation = array();

// check form submittal
if(!empty($_POST)) {
	// Sanitise POST array
	foreach($_POST as $key => $value) $_POST[$key] = remove_email_injection(trim($value));
	
	// Loop into required fields and make sure they match our needs
	foreach($required_fields as $field) {		
		// the field has been submitted?
		if(!array_key_exists($field, $_POST)) array_push($validation, $field);
		
		// check there is information in the field?
		if($_POST[$field] == '') array_push($validation, $field);
		
		// validate the email address supplied
		if($field == 'email') if(!validate_email_address($_POST[$field])) array_push($validation, $field);
	}
	
	// basic validation result
	if(count($validation) == 0) {
		// Prepare our content string
		$email_content = 'New Website Comment: ' . "\n\n";
		
		// simple email content
		foreach($_POST as $key => $value) {
			if($key != 'submit') $email_content .= $key . ': ' . $value . "\n";
		}
		
		// if validation passed ok then send the email
		mail($email_to, $email_subject, $email_content);
		
		// Update form switch
		$form_complete = TRUE;
	}
}

function validate_email_address($email = FALSE) {
	return (preg_match('/^[^@\s]+@([-a-z0-9]+\.)+[a-z]{2,}$/i', $email))? TRUE : FALSE;
}

function remove_email_injection($field = FALSE) {
   return (str_ireplace(array("\r", "\n", "%0a", "%0d", "Content-Type:", "bcc:","to:","cc:"), '', $field));
}

?>



<!DOCTYPE html>
<html lang="en-US"><head>
<meta charset="utf-8" />

<title>Contacts</title>
<link rel="shortcut icon" href="img/favicon.ico" />

    <meta name="HandheldFriendly" content="True" />
    <meta name="MobileOptimized" content="320" />
<!-- This is how to get the results you want in veiwport for iPhones and other devices -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <!-- This is the font code for google-->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lato:300|Open+Sans:700" />
	<link href="css/contacts.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/mootools/1.3.0/mootools-yui-compressed.js"></script>
 <script type="text/javascript" src="validation.js"></script>
     
	<!--[if lt IE 9]>
		<script src="js/html5shiv.js"></script>
		<script src="js/respond.min.js"></script>
	<![endif]-->
    <script type="text/javascript">
	      var nameError = '<?php echo $error_message['fullname']; ?>';
		  var emailError = '<?php echo $error_message['email']; ?>';
		   var commentError = '<?php echo $error_message['comment']; ?>';
    </script>

</head>

<body>

<div class="page">

<!-- ==== START MASTHEAD ==== -->
	<header class="masthead" role="banner">
		<p class="logo"><a href="/"><img src="img/carlogob4.jpg" alt="Jason's First Webpage with HTML5" /></a></p>


<!--This is how you put in social sites like fb, twitter, flickr and so on....-->
		
        
<nav role="navigation">
			<ul class="nav-main">
				<li><a href="index.html">Home</a></li>
				<li><a href="offer.html">What We Offer</a></li>
                <li><a href="examples.html">Code Examples</a></li>
				<li><a href="videos.html">Videos</a></li>
                <li><a href="/" class="current-page">Contact</a></li>
			</ul>
            
               <div class="search">
<form id="cse-search-box" action="http://google.com/cse">
  <input type="hidden" name="cx" value="http://google.com" />
  <input type="hidden" name="ie" value="UTF-8" />
  <input type="text" name="q" size="17" />
  <input type="submit" name="sa" value="Search" />
</form>
</div>
            
</nav> <!--End of Navigation role-->
</header>

<div id="formWrap">
<h2>We Appreciate Your Feedback!</h2>
<div id="form">
<?php if($form_complete === FALSE): ?>

<div id="form-wrap">

<form action="contacts.php" method="post" id="comments_form">
	<div class="row">
	<div class="label"><p>Name:</p> </div> <!-- end .label -->
    <div class="input">
    <input type="text" id="fullname" class="detail" name="fullname" value="<?php echo isset($_POST['fullname'])? $_POST['fullname'] : ''; ?>" />
    <?php if(in_array('fullname', $validation)): ?><span class="error"><?php echo $error_messages['fullname']; ?></span><?php endif; ?>
    
    </div><!-- end .input -->
    <div class="context">E.g. John Doe</div><!-- end .context -->
    </div><!-- end .row -->
    
    <div class="row">
	<div class="label"><p>Email:</p> </div> <!-- end .label -->
    <div class="input">
    <input type="text" id="email" class="detail" name="email" value="<?php echo isset($_POST['email'])? $_POST['email'] : ''; ?>" />
    <?php if(in_array('email', $validation)): ?><span class="error"><?php echo $error_messages['email']; ?></span><?php endif; ?>

    </div><!-- end .input -->
    <div class="context">Sending emails through this system will be read and applied back to you ASAP.</div><!-- end .context -->
    </div><!-- end .row -->
       
    
    <div class="row">
	<div class="label"><p>Message:</p> </div> <!-- end .label -->
    <div class="input2">
   <textarea id="comment" name="comment" class="mess"><?php echo isset($_POST['comment'])? $_POST['comment'] : ''; ?></textarea>
   <?php if(in_array('comment', $validation)): ?><span class="error"><?php echo $error_messages['comment']; ?></span><?php endif; ?>
   
    </div><!-- end .input -->
    </div><!-- end .row -->
    
    <div class="submit">
    <input type="submit" id="submit" name="submit" value="Send Message" />
    </div><!-- end .submit -->
    </form>
    
    <?php else: ?>
    
    <div class="thank you">
<p>Message has been sent Thank You!!!</p>
<?php endif; ?>
    
<div class="contactlogo">

          <img src="img/contactslogo.png" width="200" height="165">
</div>


</div><!-- end#form -->
</div><!-- end #formWrap -->
</div><!-- ends class div page-->
 <!-- ==== START SIDEBAR ==== -->
	<div class="contactlogo2">
		
<img src="img/contactslogo2.png" width="340" height="550">
   </div>

</body>
</html>
