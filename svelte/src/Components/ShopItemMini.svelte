<script>
    export let item;
    export let amount;

    console.log(item);
    console.log(amount);
</script>

<div>
    {item.haven.name} {item.haven.has_quality ? 'q'+item.quality : ''} x {amount}
</div>


<style>
    div {
        padding: 5px;
        border-radius: 5px;
        background-color: #272637;
        margin-top: 5px;
        margin-bottom: 5px;
    }
</style>