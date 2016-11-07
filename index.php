<?php

mysql_connect([database],[username],[password]) or die('Could not connect to DB');
mysql_select_db([database]) or die('Could not select reviews DB: ' . mysql_error());

if(isset($_POST['submit'])){
	if(!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['vehicle']) && !empty($_POST['emailaddress'])) {

		$to = $_POST['emailaddress'];
		$from = 'Ralph@aluxauto.com';
		$subject = 'Your ' . $_POST['vehicle'] . ' - Review Request from A-Lux Auto';

		$message = 'Dear ' . $_POST['firstname'] . ',

Once again, We would like to thank you for purchasing your ' . $_POST['vehicle'] . ' from us here at A-Lux Auto. All of us really appreciate your business, and we hope that we exceeded your expectations.

As you know, it makes us very proud to be members of the A-Lux Auto sales team. Our business model is designed to eliminate much of the hassle traditionally associated with car sales. Hopefully, our team has lived up to our promise which was to deliver you with a simple, honest, and hassle free vehicle purchase experience.

Would it be too much to ask that you write a quick paragraph or two on DealerRater summarizing how you feel about the experience you had here with me and the rest of the A-Lux Auto team? We would very much appreciate it.

To write an objective third party review please visit: http://www.dealerrater.com/dealer/add-review.aspx?dealerId=23858

Keep in mind, as I mentioned on the phone, that persons who leave a review for us will be entered into a drawing where you could win $200.

Thank you in advance for your consideration.

Sincerely,
Ralph Llanes
A-Lux Auto
(562) 484-3344';
		$headers = 'From: ' . $from;
		$datetimestamp = date("Y-m-d H:i:s");

		if (mail($to, $subject, $message, $headers)) {
			echo 'Request sent to ' . $_POST['firstname'] . ' ' . $_POST['lastname'] . '<br><br>';
			mysql_query("insert into reviews (firstname, lastname, vehicle, emailaddress, senton) values ('" . $_POST['firstname'] . "', '" . $_POST['lastname'] . "', '" . $_POST['vehicle'] . "', '" . $_POST['emailaddress'] . "', '" . $datetimestamp . "')") or die(mysql_error());
		} else {
			echo 'There was an error sending the message to ' . $_POST['firstname'] . ' ' . $_POST['lastname'] . '<br><br>';
		}

	} else {
		echo "Please check for errors in the form and try again.<br><br>";
	}
}

?>
<!DOCTYPE html>
<html lang="en">

<form method="post" action="<?php $_SERVER['PHP_SELF']?>">
	<table border="0" cellpadding="5" cellspacing="0" width="30%">
		<thead>
			<tr>
				<th colspan="4">Send New Request</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><input type="text" name="firstname" placeholder="First Name" required></td>
				<td><input type="text" name="lastname" placeholder="Last Name" required></td>
				<td><input type="text" name="vehicle" placeholder="Vehicle" required></td>
				<td><input type="email" name="emailaddress" placeholder="Email Address" required></td>
				<td><input type="submit" name="submit" value="Send"></td>
			</tr>
		</tbody>
	</table>
</form>

<br><br>

<table border="1" cellpadding="5" cellspacing="0" width="40%">
	<thead>
		<tr>
			<th colspan="5">Requests Sent</th>
		</tr>
	</thead>
	<tbody>
<?php

$result = mysql_query("select * from reviews order by id desc limit 20");

while ($row = mysql_fetch_array($result)) {
	echo '<tr>';
	echo '<td>' . $row['firstname'] . '</td>';
	echo '<td>' . $row['lastname'] . '</td>';
	echo '<td>' . $row['vehicle'] . '</td>';
	echo '<td>' . $row['emailaddress'] . '</td>';
	echo '<td>' . $row['senton'] . '</td>';
	echo '</tr>';
}

?>
	</tbody>
</table>

</html>
