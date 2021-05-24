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
            <RouterLink href={'/shop/'+shop.name+'/'} style='height: 100%; margin-bottom: 10px;'>
                <div class='panel-body panel panel-contents h-100'>
                    <div class='heading-mini'>{shop.name}</div>
                    <div>{shop.description ?? ''}</div>
                </div>
            </RouterLink>
        </div>
    {/each}
    </div>
</div>

<style>
    .heading-mini {
        font-size: 20px;
    }
</style>