<?php
include('database_connection.php');
if(!isset($_SESSION["user_id"]))
{
	header("location:login.php");
}


?>
<!DOCTYPE html>
<html>
<head>
	<title>Notification Sysyem</title>
	<script src="js/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>

</head>
<body>

	<br>
	<div class="container">
		<h2 align="center">PHP Like System</h2><br>
		<div align="right">
			<a href="logout.php">Logout</a>
			<br>
			<form method="post" id="form_wall">
				<textarea name="content" id="content" class="form-control" placeholder="Share anything what's on your mind."></textarea><br>
				<div align="right">
					<input type="submit" name="submit" id="submit" class="btn btn-primary btn-sm" value="Post">
				</div>
			</form>
			<br>
			<br>

			<br>
			<br>
			<h4>Latest Post</h4>
			<br>
			<div id="website_stuff"></div>
		</div>
	</div>
<script>
$(document).ready(function()
	{
		load_stuff();
		function load_stuff()
		{
			$.ajax({
				url:"load_stuff.php",
				method:"POST",
				success:function(data)
				{
					$('#website_stuff').html(data);
				}
			});
		}
		$('#form_wall').on('submit',function(event)
		{

			event.preventDefault();
			if($.trim($('#content').val()).length==0)
			{
				alert('please write something');
				return false;
			}
			else
			{
				var form_data=$(this).serialize();

				$.ajax({
					url:"insert.php",
					method:"POST",
					data:form_data,
					success: function(data)
					{
						if(data=='done')
						{
							$("#form_wall")[0].reset();
							load_stuff();
						}
					}

				});		
			}
		});
		$(document).on('click','.like_button',function(){
			var content_id=$(this).data('content_id');
			$(this).attr('disabled','disabled');
			$.ajax({

				url:"like.php",
				method:"POST",
				data:{content_id:content_id},
				success:function(data)
				{
					if(data=='done')
					{
						load_stuff();
					}
				}

			});

		})
	});

</script>
</body>
</html>