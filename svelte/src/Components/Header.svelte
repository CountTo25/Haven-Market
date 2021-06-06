<script>
    import RouterLink from './RouterLink.svelte';
</script>
<div class='header'>
	<div class='row'>
		<div class='col-4'>
			<RouterLink label='Haven Marketplace' href='/'/>
		</div>
		<div class='col-4'>

		</div>
		<div class='col-4'>
			<input class='big' placeholder='Find something 🔎'>
		</div>
	</div>
</div>

<style>
	.col-4 {
		text-align: center;
		line-height: 40px;
	}

	.header {
		height: 50px;
		padding: 5px;
	}


</style>