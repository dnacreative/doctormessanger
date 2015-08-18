<?php 

// Flag variable for site status:
define('LIVE', TRUE);

// Admin contact address:
define('EMAIL', 'robert108@usf.edu@');

// Site URL (base for all redirections. This is the address they will be redirected to if they try to access a protected page and they are not logged in.):
define ('BASE_URL', 'http://www.mblistings.com/members_area/login.php');

// Location of the MySQL connection script:
define ('MYSQL', '../dbcon.php');


// Create the error handler:
function my_error_handler ($e_number, $e_message, $e_file, $e_line, $e_vars) {

	// Build the error message.
	$message = "<p>An error occurred in script '$e_file' on line $e_line: $e_message\n<br />";
	
	// Add the date and time:
	$message .= "Date/Time: " . date('n-j-Y H:i:s') . "\n<br />";
	
	// Append $e_vars to the $message:
	$message .= "<pre>" . print_r ($e_vars, 1) . "</pre>\n</p>";
	
	if (!LIVE) { // Development (print the error).
	
		echo '<div class="error">' . $message . '</div><br />';
		
	} else { // Don't show the error:
	
		// Send an email to the admin:
		mail(EMAIL, 'Site Error!', $message, 'From: adminerror@mblistings.com');
		
		// Only print an error message if the error isn't a notice:
		if ($e_number != E_NOTICE) {
			echo '<div class="error">A system error occurred. We apologize for the inconvenience.</div><br />';
		}
	} // End of !LIVE IF.

} // End of my_error_handler() definition.

// Use my error handler.
set_error_handler ('my_error_handler');


?>