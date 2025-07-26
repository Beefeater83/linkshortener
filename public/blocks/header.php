<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<header>
   <div class="container">
        <div class="logo">
            <img src="/public/img/logo.svg" id="img"  alt="Logo">
            <div>Приберемо все зайве з посилання!</div>
        </div> 
            
        <div class="nav full">
            <a href="/">Головна</a>
            <a href="/contact/about">Про нас</a>
            <a href="/contact">Контакти</a>
            <?php if(!isset($_COOKIE['login'])): ?>
              <a href="/user/auth">Увійти</a>
            <?php else :?>
              <a href="/user">Особистий кабінет</a>    
            <?php endif ?>        
        </div>
        <div class="bars fa-solid fa-bars"></div> 
   </div> 
    

</header>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        const $mainPage = $(".main-page");
        const $bars = $(".bars");        
        const $fullNav = $(".full");
        const $xmark = $(".xmark"); 

        function handleNavigation() {
            let screenWidth = $(window).width();
            if (screenWidth > 900) {
                $fullNav.show();
                $bars.hide();
                $(".side-menu").removeClass("active");
                $mainPage.removeClass("shifted");
            } else {
                $fullNav.hide();
                $bars.show();
            }        
        }
        
        handleNavigation();
        
        $(window).resize(function() {
            handleNavigation();
        });
        
        function openMenu() {
            $mainPage.addClass("shifted");
            $(".side-menu").addClass("active");
            $bars.hide();
        }

        function closeMenu() {
            $bars.show();
            $mainPage.addClass("shifted-before-close"); 
            setTimeout(function(){
                $mainPage.addClass("shifted-before-close"); 
                $mainPage.removeClass("shifted");
                $mainPage.removeClass("shifted-before-close");            
                $(".side-menu").removeClass("active"); 
                $(".side-menu").css('display', 'none');
            }, 1000)            
        }
        
        $bars.on("click", openMenu);

        $xmark.on("click", closeMenu);     
    });
  
</script>