<script>
import RouterLink from './Components/RouterLink.svelte';
import Router from './Support/Router.svelte';
import Header from './Components/Header.svelte';
	let name = 'world';

	let baseurl = 'http://localhost:3000';
	$: night = window.night;
	window.api = {
    	home: function(cb, payload=[]) {jQuery.get(baseurl+'/api/v1/home', function(e) {cb(e)})},
		shop: function(cb, payload)	   {jQuery.get(baseurl+'/api/v1/shop/'+payload+'/view', (e)=>{cb(e)})}
	}

	window.appurl = function(path) {
		return 'http://localhost:3000/'+path;
	}

	window.cart = {
		add: {
			buy: function(shop, item) {
				if (!(shop in window.cart.buying)) {
					window.cart.buying[shop]={}
				}

				if (!(item.id in window.cart.buying[shop])) 
				{
					console.log('???');
					window.cart.buying[shop][item.id] = 0;
				}

				window.cart.buying[shop][item.id] += 1;
			},
			sell: function(shop, item) {
				//i could refer by (shop, item, action), but it feels better to have 2 separate methods: buy/sell
				if (!(shop in window.cart.selling)) {
					window.cart.selling[shop]={}
				}

				if (!(item.id in window.cart.buying[shop])) 
				{
					window.cart.selling[shop][item.id] = 0;
				}

				window.cart.selling[shop][item.id] += 1;
			},
		}, 
		buying: {},
		selling: {},
	}

	
</script>
<Header/>
<div class='all'>

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