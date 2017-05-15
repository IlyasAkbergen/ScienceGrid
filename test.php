<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	
	
<div id="app">
	
	<h1>{{ message }}</h1>
	<input type="text" v-model="message">

	<pre>{{ $data | $json }}</pre>

</div>
<script src="vue.js"></script>
<script>	
	new Vue({
		el: "#app",
		data: {
			message: "Hello"
		}
	})
</script>

</body>
