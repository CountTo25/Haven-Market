<script>
    import BGImg from "../Components/BGImg.svelte";
    export let src;
    export let item;
    export let inOffer;

    console.log(item)

    import { createEventDispatcher } from 'svelte';

    const dispatch = createEventDispatcher();

    function add() {
        dispatch('add');
    }

    function remove() {
        dispatch('remove');
    }

    function input() {
        console.log('????');
        dispatch('input', {amount: inOffer});
    }

</script>

<div class='col-xl-6 col-md-12 itemnode ib'>
    <div class='panel-item border-5'>
        <div class='row ng itemwrap'>
            <div class='col-2'>
                <BGImg {src}/>
            </div>
            <div class='col-6'>
                <div>{item.haven.name} {item.haven.has_quality ? 'q'+item.quality : ''}</div>
                <div>{item.price} {item.price === 1 ? 'coin' : 'coins'}</div>
            </div>
            <div class='col-4'>
                <div>Up to {item.amount} pieces</div>
            </div>
        </div>
            <div class='col-12 cartstatus'>
                <div class='row ng'>
                    <div class='col-4 lh-33'>
                        {#if inOffer > 0}
                        {:else}
                        {/if}
                    </div>
                    <div class='col-2 text-center lh-33 us-null c-pnt' on:click={remove}>
                        -
                    </div>
                    <div class='col-4 text-center lh-33' on:input={input}>
                        <input class='small' bind:value={inOffer}>
                    </div>
                    <div class='col-2 text-center lh-33 us-null c-pnt' on:click={add}>
                        +
                    </div>
                </div>
            </div>
        </div>
    </div>

<style>

    .lh-33 {
        line-height: 33px;
    }

    .col-12 {
        padding: 5px;
    }

    .title-left {
        font-size: 24px;
    }

    .mb-10 {
        margin-bottom: 10px;
    }

    .title {
        text-align: center;
        font-size: 24px;
    }

    .itemnode {
        padding: 5px;
    }

    .itemnode * {
        transition: 0.1s all;
    }


    .nodewrap {
        padding: 5px;
    }

    .itemwrap {
        padding: 5px;
        user-select: none;
    }

    .innerwrap {
        padding: 10px;
    }

    .panel-limited {
        
        max-height: 50vh;
        height: 50vh;
        overflow-y: scroll;
    }

    .to-null {
        color: gray;
        text-align: center;
    }

    .to-title {
        user-select: none;
    }

    .cartstatus {
        margin-top: 5px;
        border-top: 3px solid #1c1b27;
    }
</style>