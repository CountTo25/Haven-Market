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
        }

        if (shopname in window.cart.selling) {
            selling = window.cart.selling[shopname];
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
    <div class='row'>
        <div class='panel'>
            <div class='panel-contents panel-body'>
                <div class='title to-title' on:click={tradeOfferMeme}>{tradeOfferText}</div>
                <div>
                    {#if hasAnythingInCart}
                        <div class='row row-sp'>
                            <div class='col-6'>
                                {#if shopname in window.cart.selling}
                                    {#if (totalCoins.sold > 0)}
                                        <div class='text-center text-gr us-null'>
                                           You offered goods equal to {totalCoins.sold} {totalCoins.sold === 1 ? 'coin':'coins'}
                                        </div>
                                    {/if}
                                    {#each  Object.entries(window.cart.selling[shopname]) as [key, value]}
                                        {#if (value > 0)}
                                            <ShopItemMini item={shopData.selling[key]} amount={value}/>
                                        {/if}
                                    {/each}
                                {/if}
                            </div>
                            <div class='col-6'>
                                {#if shopname in window.cart.buying}
                                    {#if (totalCoins.purchased > 0)}
                                        <div class='text-center text-gr us-null'>
                                            You need to offer goods equal to {totalCoins.purchased} {totalCoins.purchased === 1 ? 'coin':'coins'}
                                        </div>
                                    {/if}
                                    {#each Object.entries(buying) as [key, value]}
                                        {#if (value > 0)}
                                            <ShopItemMini item={shopData.selling[key]} amount={value}/>
                                        {/if}
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
                {#each Object.entries(shopData.buying) as [key, item]}
                <ShopItem 
                    {item}
                    src={window.appurl('storage/icons/'+shopData.buying[key].haven.filename)}
                    inOffer={getOfferAmount(shopData.buying[key].id, 'selling')}
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