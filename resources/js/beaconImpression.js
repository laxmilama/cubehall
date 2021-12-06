
/*
This snipist is written to collect impression data for the products, showoff and parlors.


*/

window.onload = function () {

       
    var csrf = document.getElementsByName("csrf-token")[0].getAttribute('content');
    var imlist;


    document.addEventListener("visibilitychange", function () {
        imlist = getDataList();

        var blob = new Blob([JSON.stringify(
            {
                f: csrf,
                d: imlist
            }
        )],
            { type: 'application/json; charset=UTF-8' });

        if (document.visibilityState === 'hidden' && !isEmptyArray(imlist)) {
            let result = navigator.sendBeacon('/test-post', blob);

            if (result) {
                var a = document.querySelectorAll('[data-collector]');
                a.forEach(b => b.removeAttribute('data-collector'));
            }
        }
    });

    function getDataList() {
        var d = document.querySelectorAll('[data-collector]');
        var id = [];
        if (!isEmptyArray(d)) {
            d.forEach(e => {
                id.push(e.getAttribute("href"));
            });

            isChanged = true;
            return id;
        } else {
            return '';
        }
    }

    //To check if an array is empty using javascript
    function isEmptyArray(array) {
        //If it's not an array, return FALSE.
        if (!Array.isArray(array)) {
            return false;
        }
        //If it is an array, check its length property
        if (array.length == 0) {
            return true;
        }
        return false;
    }
};

