@extends('layouts.app')
@section('content')

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

@endsection