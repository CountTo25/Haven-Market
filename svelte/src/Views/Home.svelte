<script>
import RouterLink from "../Components/RouterLink.svelte";
import Shop from "./Shop.svelte";

    let data = [];
    let booting = true;
    window.api.home(function(response) {data = response; booting = false;});

</script>


<div class='body'>
    <div class='row'>
    {#each data as shop}
        <div class='col-lg-4 col-sm-12'>
            <RouterLink href={'/shop/'+shop.name+'/'}>
                <div>{shop.name}</div>
                <div>{shop.description}</div>
            </RouterLink>
        </div>
    {/each}
    </div>
</div>