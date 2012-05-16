<!DOCTYPE html>
<html>
<head>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

	<script type="text/javascript">

	$(function() {
		
		$('.catch_the_click').click(function() {
			
			var url = $(this).attr('href');
			var newWindow = $(this).attr('target') == '_blank' ? true : false;  

			//Catch the click with ajax
			catchTheClick(url, newWindow);

			//If newWindow is false, prevent the anchor to be followed instantly and let javascript redirect instead, to make sure we don't redirect before the ajax request is completed.
			//If newWindow is true, just return true and let the anchor be followed in a new window.
			return newWindow;
			
		});


		var catchTheClick = function(url, newWindow) {

			$.ajax({
				url: '_catch_click.php',
				cache: 'false',
				type: 'GET',
				data: {
					url: url
				},
				dataType: 'json',
				complete: function(data) {
					//Now the ajax request really is complete

					if(newWindow == false) {
						location.href = url;
					}

					return true;

				}
			});

			//Return true regardless to not prevent the user to be redirected.
			return true;
		};
	});

	</script>

	<title>Click catcher and redirect with ajax</title>
</head>

<body>

<a class="catch_the_click" href="http://google.dk">Google.dk</a>
<br />
<a class="catch_the_click" target="_blank" href="http://google.dk">Google.dk new window</a>
</body>

</html>