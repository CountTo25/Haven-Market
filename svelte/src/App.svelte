<script>
	import Router from './Support/Router.svelte';
	let name = 'world';

	let baseurl = 'http://localhost:3000';
	$: night = window.night;
	window.api = {
    	home: function(cb) {jQuery.get(baseurl+'/api/v1/home', function(e) {cb(e)})}
	}
</script>
<div class='all'>
<div class='header'>

</div>
<div class='main'>
	<Router/>
</div>
</div>
<style>
	.main {
		padding-left: 10vw;
		padding-right: 10vw;
	}
</style>