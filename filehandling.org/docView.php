<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<title>Read Mode</title>
	<style>
		* {
			box-sizing: border-box;
		}

		.column {
			float: left;
			width: 50%;
			padding: 5px;
		}

		/* Clearfix (clear floats) */
		.row::after {
			content: "";
			clear: both;
			display: table;
		}
	</style>
</head>

<body>
	<?php
		if(isset($_GET['ns']))
		{
			//echo $_GET['ns'];
			//echo " ".$_GET['cns'];
			$nsFile = $_GET['ns'];
			$cnsFile = $_GET['cns'];

			// taking the file extension for future use. We can use the file extension to customize the view for any file.
			$extNS	= pathinfo($nsFile, PATHINFO_EXTENSION);
			$extCNS = pathinfo($cnsFile, PATHINFO_EXTENSION);
		}
	
	?>

	<div class="row">
		<div class="column">
			<object data="<?php echo $nsFile ?>#page2" type="application/pdf" width="100%" height="100%">
				<p><b>Example fallback content</b>: This browser does not support PDFs. Please download the PDF to view it: <a href="<?php echo $nsFile ?>">Download PDF</a>.</p>
			</object>
		</div>
		<div class="column">
			<object data="<?php echo $cnsFile ?>#page=2" type="application/pdf" width="100%" height="100%">
				<p><b>Example fallback content</b>: This browser does not support PDFs. Please download the PDF to view it: <a href="<?php echo $cnsFile ?>">Download PDF</a>.</p>
			</object>
		</div>
	</div>
</body>

</html>