<script>
    import BGImg from "../Components/BGImg.svelte";
    export let src;
    export let item;
</script>

<div class='col-xl-6 col-md-12 itemnode ib' on:click>
    <div class='row ng itemwrap panel-item'>
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
</div>

<style>
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


    .nodewrap {
        padding: 5px;
    }

    .itemwrap {
        padding: 10px;
        border-radius: 5px;
        user-select: none;
    }

    .panel-item {
        cursor: pointer;
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
</style>