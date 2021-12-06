<h1>Falano Dhiskano</h1>

<meta name="csrf-token" content="{{ csrf_token() }}" />
<div post-data="1234">
    <a href="http://127.0.0.1:8000/" data-list aria-label="Current Page, Page 2">In the1</a>
    <a href="#asdf" data-list>In the2</a>
    <a href="#asdf" data-list>In the3</a>
    <a href="#asdf" data-list>In the4</a>
    <a href="#in the falano">In the4</a>
</div>

<script>
    var csrf = document.getElementsByName("csrf-token")[0].getAttribute('content');
    var isChanged = false;
    var imlist = getDataList();

    var blob= new Blob([JSON.stringify(
        {
            f:csrf,
            d:imlist}
        )], 
        {type : 'application/json; charset=UTF-8',
        'X-CSRF-Token' : csrf});
    
    document.addEventListener("visibilitychange", function() {
        if (document.visibilityState === 'hidden' && isChanged && !isEmptyArray(imlist)) {
            let result =  navigator.sendBeacon('http://192.168.1.85/test-post', blob);

            if(result){
                isChanged = false;
            }
        }
    });

    function getDataList(){
        var d = document.querySelectorAll('[data-list]');
        var id = [];
        if(!isEmptyArray(d)){
            d.forEach(e => {
            id.push(e.getAttribute("href"));
            });

            isChanged = true;
            return id;
        }else{
            return '';
        }
    }

    //To check if an array is empty using javascript
    function isEmptyArray(array){
        //If it's not an array, return FALSE.
        if(!Array.isArray(array)){
            return false;
        }
        //If it is an array, check its length property
        if(array.length == 0){
            return true;
        }
        return false;
    }


    
</script>