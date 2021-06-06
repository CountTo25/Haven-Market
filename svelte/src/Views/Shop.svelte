<script>
    import BGImg from '../Components/BGImg.svelte';
import ShopItem from '../Components/ShopItem.svelte';
import ShopItemMini from '../Components/ShopItemMini.svelte';
    export let keywords;
    let data = [];
    let booting = true;
    let shopname = keywords[0];
    let shopData = {
        selling: {},
        buying: {},
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
            if (element.selling) {
                shopData.selling[element.id] = element;
            } else {
                shopData.buying[element.id] = element;
            }

        });
    }, shopname);

    let hasAnythingInCart = shopname in (window.cart.buying) || shopname in (window.cart.selling);

    function addToCart(item, amount = 1) {
        window.cart.add.buy(shopname, item, amount);
        hasAnythingInCart = shopname in (window.cart.buying) || shopname in (window.cart.selling);
        buying = window.cart.buying[shopname];
        shaker();
    }

    function putOnSale(item, amount = 1) {
        window.cart.add.sell(shopname, item, amount);
        hasAnythingInCart = shopname in (window.cart.buying) || shopname in (window.cart.selling);
        selling = window.cart.selling[shopname]; 
        shaker();

    }

    function set(item, amount, method) {
        let parsed = isNaN(parseInt(amount)) ? 0 : parseInt(amount);
        if (!(shopname in window.cart[method]))
            window.cart[method].shopname = {};
        if (!(item.id in window.cart[method][shopname]))
            window.cart[method][shopname][item.id] = parsed;
        if (amount >= 0 && item.id in window.cart[method][shopname]) {
            window.cart[method][shopname][item.id] = parsed;
            buying = window.cart[method][shopname];
        }

        shaker();

    }

    function shaker() {
        totalCoins = getTotalCoins();
        if (shopname in window.cart.buying) {
            buying = window.cart.buying[shopname];
            isBuying = true;
        }

        if (shopname in window.cart.selling) {
            selling = window.cart.selling[shopname];
            isSelling = true;
        }
    }

    function getTotalCoins() {
        let totalSold = 0;
        let totalPurchased = 0;
        Object.keys(shopData.buying).forEach(function(id) {
            console.log(shopData.buying[id].price + '*' + window.cart.amountOf(id, shopname, 'selling'));
            totalSold += shopData.buying[id].price * window.cart.amountOf(id, shopname, 'selling');
        });

        Object.keys(shopData.selling).forEach(function(id) {
            console.log(shopData.selling[id].price + '*' + window.cart.amountOf(id, shopname, 'buying'));
            totalPurchased += shopData.selling[id].price * window.cart.amountOf(id, shopname, 'buying');
        });

        console.log('calculating');
        return {
            sold: totalSold,
            purchased: totalPurchased,
        }
    }

    let totalCoins = getTotalCoins();

    $: buying = {}
    $: selling = {}

    let isSelling = false;
    let isBuying = false;

    $: getOfferAmount = function (id, action) {
        
        let const_buying = 'buying';
        let const_selling = 'selling'; //to keep it kinda strict-ish
        if (action === const_buying) {
            return id in buying ? buying[id] : 0;
        }
        if (action === const_selling) {
            return id in selling ? selling[id] : 0;
        }

        throw 'smh';
    }

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
    <div class='row trade-offer'>
        <div class='panel fixed-200'>
            <div class='panel-contents panel-body suppress-padding'>
                <div class='title to-title' on:click={tradeOfferMeme}>{tradeOfferText}</div>
                <div class='wrap-to'>
                    {#if hasAnythingInCart}
                        <div class='row text-center to-status-text' >
                            <div class='col-4 text-center'>
                                {#if (totalCoins.sold > 0)}
                                    You offered goods equal to {totalCoins.sold} {totalCoins.sold === 1 ? 'coin':'coins'}
                                {/if}
                            </div>
                            <div class='col-4'>
                                {#if (totalCoins.sold < totalCoins.purchased)}
                                    You need to offer items worth total of {totalCoins.purchased}
                                {:else if  (totalCoins.purchased !== 0 && totalCoins.sold !== 0)}
                                    All good!
                                {/if}
                            </div>
                            <div class='col-4'>
                                {#if (totalCoins.purchased > 0)}
                                    You selected goods worth {totalCoins.purchased} {totalCoins.purchased === 1 ? 'coin':'coins'}
                                {/if}
                            </div>
                        </div>
                        <div class='row row-sp to-row'>
                            <div class='col-6'>
                                <div class='to-scroller'>
                                {#if isSelling}
                                    {#each  Object.entries(selling) as [key, value]}
                                        {#if (value > 0)}
                                            <ShopItemMini item={shopData.buying[key]} amount={value}/>
                                        {/if}
                                    {/each}
                                {/if}
                                </div>
                            </div>
                            <div class='col-6'>
                                <div class='to-scroller'>
                                {#if isBuying}
                                    {#each Object.entries(buying) as [key, value]}
                                        {#if (value > 0)}
                                            <ShopItemMini item={shopData.selling[key]} amount={value}/>
                                        {/if}
                                    {/each}
                                {/if}
                                </div>
                            </div>
                        </div>
                    {:else}
                        <div class='to-null to-status-text'>Nothing in the cart yet :(</div>
                    {/if}
                </div>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class='col-xl-6 col-12 panel'>
            <div class='panel-contents panel-body panel-limited'>
                <div class='title'>Buying</div>
                {#each Object.entries(shopData.buying) as [key, item]}
                <ShopItem 
                    {item}
                    src={window.appurl('storage/icons/'+shopData.buying[key].haven.filename)}
                    inOffer={getOfferAmount(shopData.buying[key].id, 'selling')}
                    on:add={()=>{putOnSale(item)}}
                    on:remove={()=>{putOnSale(item, -1)}}
                    on:input ={(e)=>{set(item, e.detail.amount, 'selling')}}
                />
                {/each}
            </div>
        </div>
        <div class='col-xl-6 col-12 panel'>
            <div class='panel-contents panel-body panel-limited'>
            <div class='title'>Selling</div>
            {#each Object.entries(shopData.selling) as [key, item]}
                <ShopItem 
                    {item} 
                    src={window.appurl('storage/icons/'+item.haven.filename)}
                    on:add={()=>{addToCart(item)}}
                    on:remove={()=>{addToCart(item, -1)}}
                    on:input ={(e)=>{set(item, e.detail.amount, 'buying')}}
                    inOffer={getOfferAmount(item.id, 'buying')}
                />
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

    .trade-offer {
        height: 200px;
    }

    .to-scroller {
        overflow-y: scroll;
        height: 106px;
        padding-left: 13px;
        padding-right: 11px;
    }

    .wrap-to {
        height: calc(100% - 64px);
    }

    .to-row.row {
        height: 100%;
    }

    .to-row .col-6 {
        padding: 0px;
    }

    .to-row .col-6:first-of-type {
        padding-right: 12px;
    }

    .to-row .col-6:last-of-type {
        padding-left: 12px;
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
        height: 32px;
        line-height: 32px;
    }

    .to-status-text {
        font-size: 16px;
        line-height: 32px;
        height: 32px;
    }

    .fixed-200 {
        height: 200px;
    }

    .row {
        width: 100%;
        margin: 0px;
    }

    .suppress-padding {
        padding-left: 0px;
        padding-right: 0px;
    }
</style>