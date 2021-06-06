
<script>

import Home from "../Views/Home.svelte";
import NotFound from "../Views/NotFound.svelte";
import Shop from "../Views/Shop.svelte";

let basetitle = document.title;

let routes = {
    '/': Home,
    '/shop/{name}/': {
        view: Shop,
        title: function(keywords) {return keywords[0] + '@'+basetitle}
    },
    '/404/': NotFound,
};

let fallback = '/404/';

let keywords = [];

if (!window.location.href.includes('#')) {
    //not a routed view, just / address
    window.location.href = window.location.href + '#/';
}
let urn = window.location.href.replace(window.location.origin+'/#', '');
let view = null;

getView(urn);

function getView(urn) {
    //capture variables
    let captured = captureRoute(urn);
    keywords = captured.arguments;
    if (!('view' in routes[captured.route])) {
        view = routes[captured.route];
        document.title = basetitle;
        return; //use simple schema
    }
    view = routes[captured.route].view;
    if ('title' in routes[captured.route]) {
        if (typeof routes[captured.route].title === 'function') {
            console.log('yup');
            console.log(routes[captured.route].title(keywords));
            document.title = routes[captured.route].title(keywords);
        } else {
            document.title = routes[captured.route].title;
        }
    } else {
        document.title = basetitle;
    }
}

function onBrowserHistory() {
    window.routing.goto(window.location.href.replace(window.location.origin+'/#', ''));
}

window.addEventListener('popstate', onBrowserHistory);


window.routing = {
    goto: function(route) {
        window.location.href = window.location.origin+'/#'+route;
        getView(route);
    }
}

function captureRoute(urn) {
    let args = [];
    for (const [path, _] of Object.entries(routes)) {
        let explodedPath = path.split('/');
        let explodedUrn = urn.split('/');
        if (explodedPath.length !== explodedUrn.length) {
            continue;
        }
        let matched = false;
        for (let i = 0; i < explodedPath.length; i++) {
            if (explodedPath[i] !== explodedUrn[i]) {

                //not all hope is lost
                let regexp = new RegExp(/{([^}]*)}/gi);
                if (!regexp.test(explodedPath[i])) {
                    console.log('rip the dream');
                    break;
                }
                args.push(explodedUrn[i]);
            }
            if (i === explodedPath.length - 1) 
            {
                matched = true;
            }
        }

        if (matched) {
            return {
                arguments: args,
                route: path,
            }
        }
    }

    return {
        arguments: [],
        route: fallback,
    }
}

</script>

<svelte:component this={view} {keywords}/>

