<script>
    export let keywords;
    let data = [];
    let booting = true;
    let shopname = keywords[0];
    let items = {
        selling: [],
        buying: [],
    };
    window.api.shop(function(response) {
        data = response;
        booting = false;
        data['items'].forEach(element => {
            console.log(element);
            if (element.selling === true) {
                items.selling.push(element);
            }
            if (element.selling === false) 
            {
                items.buying.push(element);
            }
        });
    }, shopname);

</script>
<div>

    {#if !booting}
    <div class='row'>
        <div class='panel'>
            <div class='panel-contents panel-body'>
                <div class='title-left mb-10'>{shopname}</div>
                <div class='mb-10'>{data['description'] ?? ''}</div>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class='col-xl-6 col-12 panel'>
            <div class='panel-contents panel-body'>
            <div class='title'>Offering</div>
            {#each items.selling as item}
                <div class='col-xl-6 col-md-12 itemnode ib'>
                        <div class='row ng itemwrap panel-item'>
                            <div class='col-6'>
                                <div>{item.haven.name} q{item.quality}</div>
                                <div>{item.price}</div>
                            </div>
                            <div class='col-6'>
                                <div>In stock: {item.amount}</div>
                            </div>
                        </div>
                </div>
            {/each}
            </div>
        </div>
        <div class='col-xl-6 col-12 panel'>
            <div class='panel-contents panel-body'>
            <div class='title'>Buying</div>
            {#each items.buying as item}
            <div class='col-xl-6 col-md-12 itemnode ib'>
                    <div class='row ng itemwrap panel-item'>
                        <div class='col-6'>
                            <div>{item.haven.name} q{item.quality}</div>
                            <div>{item.price}</div>
                        </div>
                        <div class='col-6'>
                            <div>Up to {item.amount} pieces</div>
                        </div>
                    </div>
            </div>
        {/each}
        </div>
        </div>
    </div>
    {/if}
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

    .panel {
        padding: 5px;
    }

    .panel-contents {
        border-radius: 5px;
        padding: 10px;
        height: 100%;
    }

    .nodewrap {
        padding: 5px;
    }

    .itemwrap {
        padding: 10px;
        border-radius: 5px;
    }

    .itemwrap .col-6 {
        padding: 0px;
    }
</style>