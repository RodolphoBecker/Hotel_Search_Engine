var list;
//var list = {
//        'var': 'texto',
//        'array': [1, 2, 3, 4]
//    };

jQuery(document).ready(function(){
    headerMargin();

	jQuery('#slider-home').slick({
        adaptiveHeight: true,
        infinite: true,
        arrows: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 3000,
        dots: true,        
        fade: true,
        cssEase: 'linear',
    });
 
    jQuery('#ClickCollapseMenu').on('click', function(event){
        event.preventDefault();
        jQuery(this).toggleClass('is-active');
        jQuery('.menu-principal').toggleClass('is-active');
        jQuery('#StickyHeader').toggleClass('bg-colored');
    });
        
});

jQuery(window).on('load', function(){
    topMenu();
    // fullFirstScreen();
    headerMargin();
    //jQuery('#loader-screen').addClass('hide');
});

jQuery(window).resize(function(){
    // fullFirstScreen();
});

jQuery(window).on('scroll', function () {
    topMenu();
});

function topMenu() {
    if (jQuery(this).scrollTop() > 150) {
        jQuery('#StickyHeader').addClass('sticked');      
    } else {
        jQuery('#StickyHeader').removeClass('sticked');       
    };    
};

function headerMargin() {
    var headerHeight = jQuery('#StickyHeader').height() + 30;
    var windowHeight = jQuery(window).height();
    jQuery('.menu-principal').css('margin-top', headerHeight);
    jQuery('.spacer-header-height').height(headerHeight);
    jQuery('#slider-home .slider-content').height(windowHeight);
};

function loadRooms(location, nights, date, national, adult, children, roomNumber) {
	$.ajax({
		url : "rooms.php",
		type : "post",
        dataType: "html",
        data: { location: location, nights: nights, date: date, national: national, adult: adult, children: children, roomNumber: roomNumber },
		timeout: 30000,
		success: function(retorno) {
            if ( retorno != "ERRO" ) {
                $("#list").append(retorno);
            } else {
                alert("Ocorreu um arro ao carregar as informações dos hotéis. Tente novamente dentro de alguns instantes.");
            }
            jQuery('#loader-screen').addClass('hide');
        },
		error: function() {
            alert("Ocorreu um arro ao carregar as informações dos hotéis. Tente novamente dentro de alguns instantes.");
            window.open(".", "_self");
        }
	});
}
