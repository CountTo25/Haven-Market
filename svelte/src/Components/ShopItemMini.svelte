<script>
    export let item;
    export let amount;

    console.log(item);
    console.log(amount);
</script>

<div>
    {item.haven.name} {item.haven.has_quality ? 'q'+item.quality : ''} x {amount}
</div>