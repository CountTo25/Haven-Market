<script>
    let data = [];
    let booting = true;
    window.api.home(function(response) {data = response; booting = false;});

</script>


<div class='body'>
    KEKEKE
    <div class='row'>
    {#each data as shop}
        <div class='col-lg-4 col-sm-12'>
            {shop.name}
        </div>
    {/each}
    </div>
</div>