<?php
 include_once 'header.php';
?>

<section class="main-container">
	<div class="main-wrapper">
		<?php
			if (isset($_SESSION['u_id']))
			{
			 //echo "You are logged in!";
			 include_once './admin/getusers.php';
			}
			else
			{
			 echo '<h2>Home</h2>';
			}
		?>
	</div>
</section>
<?php
 include_once 'footer.php';
?>