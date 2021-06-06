<script>
import RouterLink from "../Components/RouterLink.svelte";

</script>

<div class='notfound us-null'>404</div>
<div class='text-center'>
    There's no such page. Maybe go back home?
</div>
<div class='text-center mt-50px'>
    <span class='rl-wrap'><RouterLink href='/' isDiv={false}>Yeah, lets go</RouterLink></span>
</div>


<style>
    div.notfound {
        font-size: 40px;
        text-align: center;
        margin-top: 10vh;
    }


    .rl-wrap {
        font-size: 20px;
        padding: 5px;
        padding-left: 20px;
        padding-right: 20px;
        border-radius: 5px;
        background-color: #1c1b27;
    }
</style>