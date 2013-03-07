<html>
<head>
<title>404 Page Not Found</title>
<style type="text/css">

body {
background-color:   #000000;
margin:				40px;
font-family:		Lucida Grande, Verdana, Sans-serif;
font-size:			12px;
color:				#000;
}

#content  {
border:				#999 1px solid;
background-color:	#F89E23;
padding:			20px 20px 12px 20px;
}

h1 {
	color: #FFFFFF;
    font-size: 27px;
    font-weight: bold;
}
.centered {
	margin-left: auto;
    margin-right: auto;
    width: 18%;
}
.back-home{
	/*text-decoration: none;*/
	text-align: center;
	color: #fff;
	margin-left: 100px;
}
</style>
</head>
<body>
	<div id="content">
		<div class="centered">
			<h1><?php echo $heading; ?></h1>
			<a class="back-home" href="<?php //echo base_url(); ?>" >Back to Home</a>
		</div>
	</div>
</body>
</html>