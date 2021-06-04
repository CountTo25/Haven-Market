<script>
    import BGImg from '../Components/BGImg.svelte';
import ShopItem from '../Components/ShopItem.svelte';
    export let keywords;
    let data = [];
    let booting = true;
    let shopname = keywords[0];
    let items = {
        selling: [],
        buying: [],
    };

    let tradeOfferText = 'Trade offer';
    let tradeOfferClickCount = 0;

    function tradeOfferMeme() {
        if (tradeOfferClickCount > 5) {
            tradeOfferText = '⚠️TRADE OFFER⚠️';
            return;
        }
        tradeOfferClickCount++;
    }

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

    let hasAnythingInCart = shopname in (window.cart.buying) || shopname in (window.cart.selling);

    function addToCart(item) {
        window.cart.add.buy(shopname, item);
        hasAnythingInCart = shopname in (window.cart.buying) || shopname in (window.cart.selling);
        buying = window.cart.buying[shopname];
    }

    $: buying = {}

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
        <div class='panel'>
            <div class='panel-contents panel-body'>
                <div class='title to-title' on:click={tradeOfferMeme}>{tradeOfferText}</div>
                <div>
                    {#if hasAnythingInCart}
                        <div class='row row-sp'>
                            <div class='col-6'>
                                {#if shopname in window.cart.selling}
                                    {#each  Object.entries(window.cart.selling[shopname]) as [key, value]}
                                        {key} {value}
                                    {/each}
                                {/if}
                            </div>
                            <div class='col-6'>
                                {#if shopname in window.cart.buying}
                                    {#each Object.entries(buying) as [key, value]}
                                        {key} {value}
                                    {/each}
                                {/if}
                            </div>
                        </div>
                    {:else}
                        <div class='to-null'>Nothing in the cart yet :(</div>
                    {/if}
                </div>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class='col-xl-6 col-12 panel'>
            <div class='panel-contents panel-body panel-limited'>
                <div class='title'>Buying</div>
                {#each items.buying as item}
                <ShopItem {item} src={window.appurl('storage/icons/'+item.haven.filename)} />
                {/each}
            </div>
        </div>
        <div class='col-xl-6 col-12 panel'>
            <div class='panel-contents panel-body panel-limited'>
            <div class='title'>Selling</div>
            {#each items.selling as item}
                <ShopItem {item} src={window.appurl('storage/icons/'+item.haven.filename)} on:click={function() {addToCart(item)}}/>
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