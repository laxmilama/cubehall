 // Creating scroller for all scrollable items
 let scrolables = document.querySelectorAll('.scrollable');
 scrolables.forEach(e => {
    //  console.log(e.scrollWidth + '=' + e.clientWidth);
     if(e.scrollWidth > e.clientWidth){
        var node = document.createElement("div");
        node.classList.add('scrollbar-x');
        var f = e.parentElement.appendChild(node);

        var x = document.createElement("div");  
        x.classList.add('scrollbar-handle');
        var h = f.appendChild(x);

        var togL = document.createElement("div");
        togL.classList.add('tgl-left-btn');
        e.parentElement.appendChild(togL);

        var togR = document.createElement("div");
        togR.classList.add('tgl-right-btn');
        e.parentElement.appendChild(togR);
        // console.log(h.parentElement.previousElementSibling);
        // var hW = h.parentElement.previousElementSibling.scrollWidth - h.parentElement.previousElementSibling.clientWidth;
        // console.log(hW);
        // h.style.width=hW + 'px';
     }
 });

 document.addEventListener("mouseover", function( e ) {

     if(e.target.className == 'scrollbar-handle'){

         var contentBox = e.target.parentElement.previousElementSibling;
         let handle = e.target;

         let scrollElem = e.target.parentElement;
         var scrollX = scrollElem.clientWidth;

         var handleWidth = handle.clientWidth;

         var movable = scrollX - handleWidth;

         var contentWidth = contentBox.scrollWidth - contentBox.clientWidth;

         let rect = scrollElem.getBoundingClientRect();

         //Make the DIV element draggagle:
         dragElement(handle);

         function dragElement(elmnt) {

             var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
             if (document.getElementById(elmnt.id + "header")) {
                 /* if present, the header is where you move the DIV from:*/
                 document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
             } else {
                 /* otherwise, move the DIV from anywhere inside the DIV:*/
                 elmnt.onmousedown = dragMouseDown;
             }

             function dragMouseDown(e) {
                 e = e || window.event;
                 e.preventDefault();
                 // get the mouse cursor position at startup:
                 pos3 = e.clientX;
                 pos4 = e.clientY;
                 document.onmouseup = closeDragElement;
                 // call a function whenever the cursor moves:
                 document.onmousemove = elementDrag;
             }

             function elementDrag(e) {
                 e = e || window.event;
                 e.preventDefault();
                 // calculate the new cursor position:
                 pos1 = pos3 - e.clientX;
                 pos2 = pos4 - e.clientY;
                 pos3 = e.clientX;
                 pos4 = e.clientY;

                 if(parseInt(elmnt.style.left) < 0 || parseInt(elmnt.style.left) > movable){
                     return;
                 }

                 contentBox.scrollLeft = (elmnt.offsetLeft/movable)*contentWidth;
                 elmnt.classList.add("scrollbar-isActive");
                 elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
                 elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";

                 if(parseInt(elmnt.style.left) < 0){
                     elmnt.style.left = 0 + 'px';
                 } 
                 if(parseInt(elmnt.style.left) > movable){
                     elmnt.style.left = movable + 'px';
                 }
             }

             function closeDragElement() {
                 /* stop moving when mouse button is released:*/
                 document.onmouseup = null;
                 document.onmousemove = null;
                 elmnt.classList.remove("scrollbar-isActive");
             }
         }
     }                    
 });