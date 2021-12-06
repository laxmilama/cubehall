    // let currentMenu = localStorage.getItem("menu");

    let currentMenu = "open";

    
    var  toggleMenu = document.getElementById("collapsible");
    let  hamburger = document.getElementById('hamburger');

    var  leftFix = document.getElementById('AdmCont');

    var profile = document.getElementById('profile');

	// var currentMenu = "close";

	function switchMenu() {
		if(currentMenu == "open"){
            currentMenu = "close";

            toggleMenu.classList.remove('slide-open');
            toggleMenu.classList.add('slide-close');  

            // localStorage.setItem("menu", "close");

            // leftFix.style.paddingLeft = "50px";
            leftFix.classList.toggle('padlft');

            profile.classList.toggle('admin-close-pro');


		}else{
            currentMenu = "open";

            toggleMenu.classList.remove('slide-close');
            toggleMenu.classList.add('slide-open');

            // localStorage.setItem("menu", "open");
            leftFix.classList.toggle('padlft');
            // leftFix.style.paddingLeft = "250px";

            profile.classList.toggle('admin-close-pro');
		}
	
	}
    function switchMenuonload(){
        console.log(screen.width);
        
        if(screen.width <=900)
        {
            currentMenu = "close";
            toggleMenu.classList.remove('slide-open');
            toggleMenu.classList.add('slide-close');
            profile.classList.toggle('admin-close-pro');

        }
        else{
            toggleMenu.classList.remove('slide-close');
            toggleMenu.classList.add('slide-open');

            
        }
        
    }
    switchMenuonload();


    hamburger.addEventListener('click', ()=>{
        switchMenu();
    })