<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Simple CK Editor CSS Implementation</title>
	<link rel="stylesheet" href="">
	<script src="{{url('js/jquery.min.js')}}"></script>
	<script src="{{url('ckeditor/ckeditor.js')}}"></script>
</head>
<body>
	<style>
		* {
			margin:10px auto;
			text-align: center;
		}
	</style>
	<div style="width: 800px;" class="center">
		<form action="">
			<textarea name="editor" id="ckview" cols="30" rows="10">Your Text from Editor</textarea>
		</form>
	</div>
	<script>
		var ckview = document.getElementById("ckview");
		CKEDITOR.replace(ckview,{
			language:'en-gb'
		});
	</script>
</body>
</html>