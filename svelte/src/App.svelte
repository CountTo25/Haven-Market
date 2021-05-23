<script>
	import RouterLink from './Components/RouterLink.svelte';
import Router from './Support/Router.svelte';
	let name = 'world';

	let baseurl = 'http://localhost:3000';
	$: night = window.night;
	window.api = {
    	home: function(cb, payload=[]) {jQuery.get(baseurl+'/api/v1/home', function(e) {cb(e)})},
		shop: function(cb, payload)	   {jQuery.get(baseurl+'/api/v1/shop/'+payload+'/view', (e)=>{cb(e)})}
	}
</script>
<div class='all'>
<div class='header row'>
	<div class='col-4'>
		<RouterLink label='Haven Marketplace' href='/'/>
	</div>
	<div class='col-4'>

	</div>
	<div class='col-4'>

	</div>
</div>
<div class='main'>
	<Router/>
</div>
</div>
<style>
	.header {
		width: 100vw;
	}
	.main {
		padding-left: 10vw;
		padding-right: 10vw;
	}
</style>