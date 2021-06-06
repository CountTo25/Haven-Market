<script>
    export let href = '/';
    export let style = '';
    export let isDiv = true;
    //need to find better way for isDiv;
</script>

{#if isDiv}
<div {style} on:click={window.routing.goto(href)}>
    <slot></slot>
</div>
{:else}
<span {style} on:click={window.routing.goto(href)}>
    <slot></slot>
</span>
{/if}

<style>
    div,span {
        cursor: pointer;
    }
</style>

