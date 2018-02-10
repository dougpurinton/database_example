<?php
include_once 'includes/dbh.inc.php';

if ($conn)
{
 $query = "SELECT user_id, user_first, user_last, user_email, user_uid, user_code FROM users";

 $response = @mysqli_query($conn, $query);

	if ($response)
	{ ?>
<button id="button_submit" disabled="disabled">Delete Selected</button><br>
<table id="table_admin" cellpadding="8">
<tr>
<th class="col_id" id="th_id">I.D.</th>
<th class="col_fn" id="th_fn">First Name</th>
<th class="col_ln" id="th_ln">Last Name</th>
<th class="col_email" id="th_email">Email</th>
<th class="col_uid" id="th_uid">User I.D.</th>
<th class="col_code" id="th_code">Code</th>
<th class="col_select" id="th_select">Select</th>
</tr>

		<?php
		// mysqli_fetch_array will return a row of data from the query
		// until no further data is available
		while($row = mysqli_fetch_array($response))
		{ ?>
<tr>
 <td class="col_id" align="left"><?php echo $row['user_id']; ?></td>
 <td class="col_fn" align="left"><?php echo $row['user_first']; ?></td>
 <td class="col_ln" align="left"><?php echo $row['user_last']; ?></td>
 <td class="col_email" align="left"><?php echo $row['user_email']; ?></td>
 <td class="col_uid" align="left"><?php echo $row['user_uid']; ?></td>
 <td class="col_code" align="left"><?php echo $row['user_code']; ?></td>
 <td class="col_select"><input class="sampleCheckbox" name="sampleCheckbox" id="sampleCheckbox<?php echo $row['user_id']; ?>" value="sampleCheckbox<?php echo $row['user_id']; ?>" type="checkbox"></td>
 </tr>
		<?php }; ?>
</table>
<script type = "text/javascript">
// This function returns the element passed to it by using its ID. Its used to simply improve the efficiency of coding event handlers.
function $(id) {return document.getElementById(id);}

// This function accounts for older browsers so that this web page knows whether or not it can operate correctly or not.
function addEvent(element, evnt, funct)
{
	if (element.attachEvent)
	{return element.attachEvent("on"+evnt, funct);}
	else
	{return element.addEventListener(evnt, funct, false);}
}

// This function will run when the page fully loads, and without causing any errors.
function afterAllLoadsGoGoGo()
{
 $("button_submit").disabled = false;
}

function checkSelectedInTableAdmin()
{
 // Declare variables
 var tr, td, i, myStr;
 var myArray = [];
 tr = $("table_admin").getElementsByTagName("tr");

 /*
 Below is another way of assigning 'td', however, note that if it's used and another column
 is added to the html table, the 'td' offset (currently 6) would change, which would mean that
 the offset '6' would have to change if the column was added before the 6th column.
 
 td = tr[i].getElementsByTagName("td")[6];
 */
 
  // Loop through all table rows, and hide those who don't match the search query
	for (i = 1; i < tr.length; i++)
	{
	 td = tr[i].querySelectorAll("td.col_select")[0]; // old (worse) version: td = tr[i].getElementsByTagName("td")[6];
		if (td.getElementsByTagName("input")[0].checked == true)
		{
		 myStr = td.getElementsByTagName("input")[0].id.replace("sampleCheckbox", "");
			if (!Number.isNaN(Number(myStr)))
			{
			 myStr = String(Math.trunc(Number(myStr)));
			 myArray.push(myStr);
			}
		}
	}

 var myJSON = JSON.stringify(myArray);

 var http = new XMLHttpRequest();
 var url = "admin/deleteuser.php";
 var params = "postStr=" + String(myJSON);
 http.open("POST", url, true);

 //Send the proper header information along with the request
 http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 //http.setRequestHeader("Content-length", params.length);
 //http.setRequestHeader("Connection", "close");

 //Call a function when the state changes.
	http.onreadystatechange = function()
	{
		if(http.readyState == 4 && http.status == 200)
		{
		 //alert(http.responseText);
		 location.reload();
		}
	}

 http.send(params);
}

addEvent(window, "load", afterAllLoadsGoGoGo);
addEvent($("button_submit"), "click", checkSelectedInTableAdmin);
</script>

	<?php }
	else
	{
	 echo "There was a problem with the query!";
	}
 mysqli_close($conn);
}
else
{
 echo "Couldn't issue database query<br />";
 echo mysqli_connect_error($conn);
};

?>