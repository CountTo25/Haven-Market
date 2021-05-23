<script>
    export let href = '/';
    export let label = '';
    export let style = '';
</script>

<div {style} on:click={window.routing.goto(href)}>
    {label}
    <slot></slot>
</div>

<style>
    div {
        cursor: pointer;
    }
</style>

