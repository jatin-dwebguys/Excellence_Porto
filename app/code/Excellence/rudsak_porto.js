jQuery(document).ready(function(){
    /*Filter Click in phone size*/
    jQuery(window).load(function() {
        // console.log('tetetst');
        if(jQuery(window).width() < 768){
            jQuery('.filter-title strong').off();
            jQuery('.filter-title strong').click(function(e){
            console.log('test');
                jQuery('html, body').animate({
                    scrollTop: jQuery(".sidebar.sidebar-main").offset().top
                }, 1000);
            });
        }
    });

    /*Window Resize Problem*/
    jQuery(window).resize(function(){
        if(jQuery(window).width() >= 768){
            if(jQuery('html.nav-before-open').length != 0){
                jQuery('html').removeClass('nav-before-open');
                jQuery('body').removeClass('small-device-screen');
                jQuery('.page-wrapper').removeClass('small-device-screen');
            }
            if(jQuery('.pslogin-block.pslogin-login').length != 0){
                btnWidth = jQuery('.form.form-login').width() *83.5 /100;
                jQuery('.pslogin-button-text').width(btnWidth -43);
            }
            /*Search Block on resize*/
            jQuery('.page-header.type4.rudsak-porto .block-search').css("width", jQuery(window).width());
            /*Menu Modification on window resize*/
            var navWidth = jQuery('.sections.nav-sections').width();
            var searchWidth = jQuery('.search-area').width();
            jQuery('.page-header.type4.rudsak-porto .bottom-panel-group').width(navWidth + searchWidth + 1);
            var menuWidth = jQuery(window).width();//* 99.9/100;
            var leftGap = (jQuery('.page-header.type4.rudsak-porto .sections.nav-sections').offset().left) * (-1);
            var cssAdd = "margin-left: "+leftGap+"px !important; width: "+menuWidth+"px !important";
            jQuery('.page-header.type4.rudsak-porto .level0.submenu').css("cssText", cssAdd);
            // console.log(jQuery(window).width());
        }
        else{
            jQuery('.sm-header .nav-sections-item-title .nav-sections-item-switch').html('MENU');
            if(jQuery('html.nav-before-open').length == 0){
                jQuery('body').addClass('small-device-screen');
                jQuery('.page-wrapper').addClass('small-device-screen');
                jQuery('html').addClass('nav-before-open');
            }
            if(jQuery('.pslogin-block.pslogin-login').length != 0){
                jQuery('.pslogin-button-text').css("cssText", "width: 100%");
            }
            var countToggleClick = 1;
            jQuery('.open-children-toggle').off();
            jQuery('.open-children-toggle').click(function(){
                var submenu = jQuery(this).parent('li').find('.submenu.level0');
                submenu.toggleClass('opened');
            });
            jQuery('.filter-title strong').off();
            jQuery('.filter-title strong').click(function(e){
                jQuery('html, body').animate({
                    scrollTop: jQuery(".sidebar.sidebar-main").offset().top
                }, 1000);
            });

        }
    });

    /*Responsive category click open subcategory*/
    jQuery(window).bind("load", function() {
        
        jQuery('.navigation li.level0 > a.level-top').click(function(e){
            if(jQuery(window).width() < 768){
                e.preventDefault();
                jQuery(this).parent().find('.open-children-toggle').click();
            }
            
            // console.log('test687687');
        });
    });

    jQuery('.swatch-option').off('hover');
    jQuery(window).bind("load", function() {
        jQuery('.swatch-option').off('hover');
    });

    // jQuery('.filter-options-item').addClass('allow active');
    // jQuery('.filter-options-title').off('click');
    // jQuery(window).bind("load", function() {
    //     jQuery('.filter-options-title').click(function(){
    //         console.log(jQuery(this).parent('.filter-options-item'));
    //         jQuery(this).parent().removeClass('allow');
    //         jQuery(this).parent().removeClass('active');
    //     });
    // });

    if(jQuery('.full-screen-slider').length == 0){
        jQuery('.block-search').css('top', jQuery(".rudsak-porto .subchildmenu .ui-menu-item a").offset().top-2);
    }
    /*special price*/
    if(jQuery('.old-price').length != 0){
        jQuery('.old-price').insertAfter('.special-price');
    }

    jQuery(document).on("click",".select2OptionPicker li a", function(){
        jQuery(this).parents("ul").find("li a").each(function(){
            if(jQuery(this).attr("class") != "picked"){
                jQuery(this).parent().css('border-color','transparent');
            }
        });
        jQuery(this).parent().css('border-color','#000');
    });
    jQuery(document).on("mouseover",".select2OptionPicker li a", function(){
        jQuery(this).parent().css('border-color','#000');
    });
    jQuery(document).on("mouseout",".select2OptionPicker li a", function(){
        if(jQuery(this).attr("class") != "picked"){
            jQuery(this).parent().css('border-color','transparent');
        }
        
    });
    jQuery(document).on("click",".select2OptionPicker li a",function(){
        var indexElem = jQuery(this).parents('.field.configurable.required').index() + 1;
        jQuery('.field.configurable.required').eq(indexElem).find('.select2OptionPicker').remove();
        jQuery('.field.configurable.required').eq(indexElem).find('.super-attribute-select').find("option[value='']").remove();
        jQuery('.field.configurable.required').eq(indexElem).find('.super-attribute-select').select2OptionPicker();

    });
    jQuery('.product-info-main .product-info-price .product-info-stock-sku').insertBefore(jQuery('.product-info-main .product-info-price .price-box'));
    jQuery('.product-info-main .product.pricing').hide();
    var docWidth = jQuery(document).width()*0.31;
    var marginRight = jQuery(document).width()*.005;
    var menuWidth = jQuery('.sections.nav-sections').width()+jQuery('.search-area').width()+10;
    // if (menuWidth < docWidth) {
    //         jQuery('.bottom-panel-group').width(docWidth);
    // }
    // else{
            // jQuery('.bottom-panel-group').width(jQuery('.sections.nav-sections').width()+jQuery('.search-area').width()-marginRight);
    // }
    
    if(jQuery('.pslogin-block.pslogin-login').length != 0){
        jQuery('.actions-toolbar > .secondary').first().insertBefore('.block-customer-login .actions-toolbar > .primary')
        jQuery('.actions-toolbar > .secondary').first().css('margin-bottom','25px');
    }

    if(jQuery(window).width() >= 768){
        jQuery('.page-header.type4.rudsak-porto .sections.nav-sections').ready(function(){
            console.log('test111');
            jQuery('.page-header.type4.rudsak-porto .bottom-panel-group').width(jQuery('.sections.nav-sections').width()+jQuery('.search-area').width()+1);
        });
        jQuery(window).bind("load", function() {
            var marginRight = jQuery(document).width()*.005;
            // jQuery('.page-header.type4.rudsak-porto .bottom-panel-group').width(jQuery('.sections.nav-sections').width()+jQuery('.search-area').width() + 1);
            /*Menu Modification*/
            jQuery('.page-header.type4.rudsak-porto .sections.nav-sections').ready(function(){
                var marginRight = jQuery(document).width()*.005;
                // console.log('tesxt');
                // jQuery('.page-header.type4.rudsak-porto .bottom-panel-group').width(jQuery('.sections.nav-sections').width()+jQuery('.search-area').width()+1);
                var menuWidth = jQuery(document).width();//* 99.9/100;
                var leftGap = (jQuery('.page-header.type4.rudsak-porto .sections.nav-sections').offset().left) * (-1);
                var cssAdd = "margin-left: "+leftGap+"px !important; width: "+menuWidth+"px !important";
                jQuery('.page-header.type4.rudsak-porto .level0.submenu').css("cssText", cssAdd);
            });
        });
      

        if(jQuery('.pslogin-block.pslogin-login').length != 0){
            // jQuery('.actions-toolbar > .secondary').first().insertBefore('.block-customer-login .actions-toolbar > .primary')
            // jQuery('.actions-toolbar > .secondary').first().css('margin-bottom','25px');
            btnWidth = jQuery('.form.form-login').width() *83.5 /100;
            jQuery('.pslogin-button-text').width(btnWidth -43);
            // if(jQuery('.pslogin-button-text').text() == "Login with Facebook"){
            //     jQuery(this).text("Sign in with Facebook");
            // }
        }

        jQuery('.awarp_related_inside_product').width(jQuery(window).width()*0.95);

        jQuery('.page-header.type4.rudsak-porto .block-search').css("width", jQuery(window).width());
        jQuery(".page-header.type4.rudsak-porto .search-toggle-icon").click(function(event){
            event.preventDefault();
            jQuery(".page-header.type4.rudsak-porto .search-area").toggleClass("clicked-search-area");
            jQuery(".page-header.type4.rudsak-porto .block-search").toggle();
        });
        jQuery(".page-header.type4.rudsak-porto #close-searchbox").click(function(event){
            event.preventDefault();
            jQuery(".page-header.type4.rudsak-porto .search-area").removeClass("clicked-search-area");
            jQuery(".page-header.type4.rudsak-porto .block-search").hide();
        });
        jQuery('#size-filterbar .filter-options-content .item').each(function(){
            if(jQuery(this).width()< 30){
                jQuery(this).width(20);
            }else{
                jQuery(this).width(jQuery(this).childern('a').width()+4);
            }
        });
    }    
    var titleText = jQuery('.page-title span').text();
    // if (titleText == "SHOP - IN YOUR BAG" || titleText == "Customer Login" || titleText == "Create New Customer Account") {
    //     jQuery('body').addClass('top-black');
    // }
    if (titleText == "Customer Login") {
        jQuery('.page-title span').hide();
    }
    if (titleText == "CREATE A NEW ACCOUNT") {
       jQuery('.page-title-wrapper').css('padding-left', '20%');
    }
    
    

    /*Minicart Hide/Show*/
    jQuery('*').click(function(){
        if (jQuery('.page-header.type4.rudsak-porto .minicart-wrapper .ui-dialog.ui-widget.ui-widget-content.ui-corner-all.ui-front.mage-dropdown-dialog').css('display') == "none") {
            jQuery(".page-header.type4.rudsak-porto .minicart-wrapper").removeClass("minicart-wrapper-clicked");
        }
    });
    jQuery('.showcart').click(function(event){
        event.preventDefault();
        // jQuery(".search-area").toggle();
        jQuery(".page-header.type4.rudsak-porto .minicart-wrapper").toggleClass("minicart-wrapper-clicked");
    });
    jQuery('.page-header.type4.rudsak-porto #switcher-language-trigger').click(function(event){
        event.preventDefault();
        jQuery(".page-header.type4.rudsak-porto .minicart-wrapper").removeClass("minicart-wrapper-clicked");
    });
    if(jQuery(window).width() >= 768){

        jQuery('.sm-header strong.logo').appendTo('header.sm-header .logo-container');

        // jQuery('.page-header.type4:nth-child(1) .minicart-wrapper .action.showcart').click(function(){
        //     jQuery('.page-header.type4.rudsak-porto .minicart-wrapper .ui-dialog.ui-widget.ui-widget-content.ui-corner-all.ui-front.mage-dropdown-dialog').toggle();
        // });

        if(jQuery('.amlocator-index-index').length == 0){
            var isSticky = 0;
            jQuery(window).scroll(function() {
                if(jQuery(".header-category-desc").length == 0){
                    if (jQuery(document).scrollTop() >= 10 && isSticky == 0) {
                        // jQuery('body').removeClass('top-black'); 
                        jQuery('.page-header.type4').addClass("sticky-menu");
                        jQuery('.sticky-logout-button').show();
                        isSticky = 1;
                    }
                    if (jQuery(document).scrollTop() <= 10 && isSticky==1) {
                        if (jQuery(".news-popup").length == 0 && jQuery(".header-category-desc").length == 0) {
                            // jQuery('body').addClass('top-black');
                        }
                        jQuery('.page-header.type4').removeClass("sticky-menu");
                        jQuery('.sticky-logout-button').hide();
                        isSticky = 0;
                    }
                }
                else{
                    var backImageUrl = jQuery('.page-header.type4').css('background-image');
                    if (jQuery(document).scrollTop() > 10 && isSticky == 0) {
                        // jQuery('body').removeClass('top-black'); 
                        jQuery('.page-header.type4').animate({height: "auto"});
                        jQuery(".header-category-desc").hide();
                        jQuery('.page-header.type4').addClass("sticky-menu");
                        jQuery('.sticky-logout-button').show();
                        isSticky = 1;
                    }
                    if (jQuery(document).scrollTop() <= 10 && isSticky==1) {
                        // if (jQuery(".news-popup").length == 0 && jQuery(".header-category-desc").length == 0) {
                        //     jQuery('body').addClass('top-black');
                        // }
                        jQuery('.page-header.type4').animate({height: "550px"});
                        jQuery(".header-category-desc").show();
                        jQuery('.page-header.type4').removeClass("sticky-menu");
                        jQuery('.sticky-logout-button').hide();
                        isSticky = 0;
                    }
                }
                
            });
        }
    }
    jQuery( ".footer-middle .container .row .col-sm-3:last-child" ).remove();

    if(jQuery(window).width() < 768){
        jQuery('html').addClass('nav-before-open');
        jQuery('body').addClass('small-device-screen');
        jQuery('.page-wrapper').addClass('small-device-screen');
        // jQuery('.filter-title strong').off();
        // jQuery('.filter-title strong').click(function(e){
        //     // jQuery('.category-custom-sidebar').toggle();
        //     // console.log('test');
        //     jQuery('html, body').animate({
        //         scrollTop: jQuery(".sidebar.sidebar-main").offset().top
        //     }, 1000);
        // });
        jQuery('.page-header.type4:nth-child(2) .minicart-wrapper .action.showcart').off();
        jQuery('.page-header.type4:nth-child(2) .minicart-wrapper .action.showcart').click(function(){
            // jQuery(this).off();
            console.log('clicked');
            window.location.href = 'checkout/cart';
        });
        jQuery('.sm-header .nav-sections-item-title .nav-sections-item-switch').html('MENU');
        // jQuery('.action.nav-toggle').off();
        // jQuery('html').addClass('nav-before-open');
        // jQuery('.action.nav-toggle').click(function(){
        //     console.log('testtests');
        //     jQuery('html').toggleClass('nav-open');
        // });
        // jQuery(window).load(function(){
        //     jQuery('.action.nav-toggle').off();
        //     jQuery('html').addClass('nav-before-open');
        //     jQuery('.action.nav-toggle').click(function(){
        //         console.log('testtests');
        //         jQuery('html').toggleClass('nav-open');
        //     });
        // });

        jQuery('.ui-menu-item.level0 .open-children-toggle').off();
        jQuery('.open-children-toggle').click(function(){
            jQuery(this).parent().find('.level0.submenu').toggleClass('opened');
            // console.log(jQuery(this).parent().find('.level0.submenu').height());
        });
    }
});