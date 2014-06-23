<?php
/* -----------------------------------------------------------------------------------------
  $Id: header.php 1140 2011-02-06 20:14:56 VaM $

  VaM Shop - open source ecommerce solution
  http://vamshop.ru
  http://vamshop.com

  Copyright (c) 2007 VaM Shop
  -----------------------------------------------------------------------------------------
  based on:
  (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
  (c) 2002-2003 osCommerce(header.php,v 1.40 2003/03/14); www.oscommerce.com
  (c) 2003	 nextcommerce (header.php,v 1.13 2003/08/17); www.nextcommerce.org
  (c) 20054 xt:Commerce (header.php,v 1.13 2005/08/10); xt-commerce.com

  Released under the GNU General Public License
  -----------------------------------------------------------------------------------------
  Third Party contribution:

  Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
  http://www.oscommerce.com/community/contributions,282
  Copyright (c) Strider | Strider@oscworks.com
  Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
  Copyright (c) Andre ambidex@gmx.net
  Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org


  Released under the GNU General Public License
  --------------------------------------------------------------------------------------- */
if (!isset($_COOKIE['curbg'])) {
    $url = DIR_FS_DOCUMENT_ROOT . DIR_WS_IMAGES . "backgrounds/"; // полный путь к папке с кешем от корня сервера.
    $dir = opendir($url);
    while (($file = readdir($dir)) !== false) {
        $bglist[] = pathinfo($file);
    }
    $curbg = $bglist[rand(2, count($bglist))]['basename'];
    setcookie('curbg', $curbg);
} else {
    $curbg = $_COOKIE['curbg'];
}

if (isset($_GET['cat']) or isset($_GET['manufacturers_id']) or isset($_GET['products_id'])) {
    setcookie('WCSmenu', 3, time() + 3600);
} elseif ($_GET['coID'] == 14) {
    setcookie('WCSmenu', 2, time() + 3600);
} elseif ($_GET['coID'] == 6) {
    setcookie('WCSmenu', 4, time() + 3600);
} elseif ($_GET['coID'] == 13) {
    setcookie('WCSmenu', 5, time() + 3600);
} elseif ($_GET['coID'] == 7) {
    setcookie('WCSmenu', 6, time() + 3600);
} else {
    setcookie('WCSmenu', 1, time() + 3600);
    $vamTemplate->assign('nobread', true);
}
if ($_GET['cat'] == 0 or $_GET['cat'] == 7)
    $vamTemplate->assign('nofilter', true);
	
    $vamTemplate->assign('CURRENTSCRIPT', $_SERVER['PHP_SELF']);
    if (isset($_GET['cat']))
       $vamTemplate->assign('ISCAT', true);
	   
	if ($_SERVER['PHP_SELF'] == '/redirector.php') {
		$vamTemplate->assign('ISMAINPAGE', true);
	}
	if (isset($_GET['manufacturers_id'])) {
		$vamTemplate->assign('MANUFACTURER_PRODUCTS', true);
	}
	   
	if ($_GET['manufacturers_id']) {
	   	$vamTemplate->assign('ISMANUFPAGE', true);
		
		$query = "SELECT manufacturers_description FROM ".TABLE_MANUFACTURERS_INFO." where manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "' and languages_id = '".$_SESSION['languages_id']."'";
		$open_query = vamDBquery($query);
		$open_data = vam_db_fetch_array($open_query, true);
		$manufacturers_description = $open_data["manufacturers_description"]; 
		$vamTemplate->assign('MANUFACTURERS_DESCRIPTION', $manufacturers_description);
	}

	   
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html <?php echo HTML_PARAMS; ?>>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>" />
        <meta http-equiv="Content-Style-Type" content="text/css" />
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo 'templates/'.CURRENT_TEMPLATE.'/style.css'; ?>" title="style" media="screen" />
		<script type="text/javascript" src="jscript/jquery/script.js"></script>
        <?php include(DIR_WS_MODULES . FILENAME_METATAGS); ?>
        <base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo 'templates/' . CURRENT_TEMPLATE . '/stylesheet.css'; ?>" />
        <?php
        if (isset($_GET['products_id']) && strstr($PHP_SELF, FILENAME_PRODUCT_INFO)) {
            ?>
            <link rel="canonical" href="<?php echo CanonicalUrl(); ?>" />
            <?php
        }
        ?>
        <?php
        if (isset($_GET['cat']) && isset($current_category_id) && strstr($PHP_SELF, FILENAME_DEFAULT)) {
            ?>
            <link rel="canonical" href="<?php echo CanonicalUrl(); ?>" />
            <?php
        }
        ?>
        <?php
        if (isset($_GET['articles_id']) && strstr($PHP_SELF, FILENAME_ARTICLE_INFO)) {
            ?>
            <link rel="canonical" href="<?php echo CanonicalUrl(); ?>" />
            <?php
        }
        ?>
        <?php
        if (isset($tPath) && strstr($PHP_SELF, FILENAME_ARTICLES)) {
            ?>
            <link rel="canonical" href="<?php echo CanonicalUrl(); ?>" />
            <?php
        }
        ?>
        <?php
        if (isset($_GET['news_id']) && strstr($PHP_SELF, FILENAME_NEWS)) {
            ?>
            <link rel="canonical" href="<?php echo CanonicalUrl(); ?>" />
            <?php
        }
        ?>
        <?php
        if (isset($_GET['faq_id']) && strstr($PHP_SELF, FILENAME_FAQ)) {
            ?>
            <link rel="canonical" href="<?php echo CanonicalUrl(); ?>" />
            <?php
        }
        ?>
        <link rel="shortcut icon" href="<?=HTTP_SERVER ?>/favicon.ico" type="image/x-icon" />
        <link rel="alternate" type="application/rss+xml" title="<?php echo TEXT_RSS_NEWS; ?>" href="<?php echo HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2 . '?feed=news'; ?>" />
        <link rel="alternate" type="application/rss+xml" title="<?php echo TEXT_RSS_ARTICLES; ?>" href="<?php echo HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2 . '?feed=articles'; ?>" />
        <link rel="alternate" type="application/rss+xml" title="<?php echo TEXT_RSS_CATEGORIES; ?>" href="<?php echo HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2 . '?feed=categories'; ?>" />
        <link rel="alternate" type="application/rss+xml" title="<?php echo TEXT_RSS_NEW_PRODUCTS; ?>" href="<?php echo HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2 . '?feed=new_products&amp;limit=10'; ?>" />
        <link rel="alternate" type="application/rss+xml" title="<?php echo TEXT_RSS_FEATURED_PRODUCTS; ?>" href="<?php echo HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2 . '?feed=featured&amp;limit=10'; ?>" />
        <link rel="alternate" type="application/rss+xml" title="<?php echo TEXT_RSS_BEST_SELLERS; ?>" href="<?php echo HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2 . '?feed=best_sellers&amp;limit=10'; ?>" />
        
        
   <?php if (!isset($_GET['cat']) && $_SERVER['PHP_SELF'] == '/redirector.php' && !isset($_GET['manufacturers_id'])) { ?>
        
              
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
 <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.3/jquery-ui.min.js"></script>
        
		<script type="text/javascript" src="jscript/cookie.js"></script>
        <?php if (AJAX_CART == 'true') { ?>
            <script type="text/javascript" src="jscript/jscript_ajax_cart.js"></script>
        <?php } ?>



        <?php
		// require theme based javascript
        require('templates/' . CURRENT_TEMPLATE . '/javascript/general.js.php');

        if (strstr($PHP_SELF, FILENAME_CHECKOUT_PAYMENT)) {
            echo $payment_modules->javascript_validation();
        }

        if (strstr($PHP_SELF, FILENAME_CREATE_ACCOUNT)) {
            require(DIR_WS_INCLUDES . 'form_check.js.php');
        }

        if (strstr($PHP_SELF, FILENAME_CHECKOUT_ALTERNATIVE)) {
            require(DIR_WS_INCLUDES . 'form_check.js.php');
        }

        if (strstr($PHP_SELF, FILENAME_CREATE_GUEST_ACCOUNT)) {
            require(DIR_WS_INCLUDES . 'form_check.js.php');
        }
        if (strstr($PHP_SELF, FILENAME_ACCOUNT_PASSWORD)) {
            require(DIR_WS_INCLUDES . 'form_check.js.php');
        }
        if (strstr($PHP_SELF, FILENAME_ACCOUNT_EDIT)) {
            require(DIR_WS_INCLUDES . 'form_check.js.php');
        }
        if (strstr($PHP_SELF, FILENAME_ADDRESS_BOOK_PROCESS)) {
            if (isset($_GET['delete']) == false) {
                include(DIR_WS_INCLUDES . 'form_check.js.php');
            }
        }
        if (strstr($PHP_SELF, FILENAME_CHECKOUT_PAYMENT)) {
            require(DIR_WS_INCLUDES . 'form_check.js.php');
        }
        if (strstr($PHP_SELF, FILENAME_CHECKOUT_SHIPPING_ADDRESS) or strstr($PHP_SELF, FILENAME_CHECKOUT_PAYMENT_ADDRESS)) {
            require(DIR_WS_INCLUDES . 'form_check.js.php');
            ?>
            <script type="text/javascript"><!--
                function check_form_optional(form_name) {
                    var form = form_name;

                    var firstname = form.elements['firstname'].value;
                    var lastname = form.elements['lastname'].value;
                    var street_address = form.elements['street_address'].value;

                    if (firstname == '' && lastname == '' && street_address == '') {
                        return true;
                    } else {
                        return check_form(form_name);
                    }
                }
                //--></script>
            <?php
        }

        if (strstr($PHP_SELF, FILENAME_ADVANCED_SEARCH)) {
            ?>
            <script type="text/javascript" src="includes/general.js"></script>
            <script type="text/javascript"><!--
                function check_form() {
                    var error_message = unescape("<?php echo vam_js_lang(JS_ERROR); ?>");
                    var error_found = false;
                    var error_field;
                    var keywords = document.getElementById("advanced_search").keywords.value;
                    var pfrom = document.getElementById("advanced_search").pfrom.value;
                    var pto = document.getElementById("advanced_search").pto.value;
                    var pfrom_float;
                    var pto_float;

                    if ( (keywords == '' || keywords.length < 1) && (pfrom == '' || pfrom.length < 1) && (pto == '' || pto.length < 1) ) {
                        error_message = error_message + unescape("<?php echo vam_js_lang(JS_AT_LEAST_ONE_INPUT); ?>");
                        error_field = document.getElementById("advanced_search").keywords;
                        error_found = true;
                    }

                    if (pfrom.length > 0) {
                        pfrom_float = parseFloat(pfrom);
                        if (isNaN(pfrom_float)) {
                            error_message = error_message + unescape("<?php echo vam_js_lang(JS_PRICE_FROM_MUST_BE_NUM); ?>");
                            error_field = document.getElementById("advanced_search").pfrom;
                            error_found = true;
                        }
                    } else {
                        pfrom_float = 0;
                    }

                    if (pto.length > 0) {
                        pto_float = parseFloat(pto);
                        if (isNaN(pto_float)) {
                            error_message = error_message + unescape("<?php echo vam_js_lang(JS_PRICE_TO_MUST_BE_NUM); ?>");
                            error_field = document.getElementById("advanced_search").pto;
                            error_found = true;
                        }
                    } else {
                        pto_float = 0;
                    }

                    if ( (pfrom.length > 0) && (pto.length > 0) ) {
                        if ( (!isNaN(pfrom_float)) && (!isNaN(pto_float)) && (pto_float < pfrom_float) ) {
                            error_message = error_message + unescape("<?php echo vam_js_lang(JS_PRICE_TO_LESS_THAN_PRICE_FROM); ?>");
                            error_field = document.getElementById("advanced_search").pto;
                            error_found = true;
                        }
                    }

                    if (error_found == true) {
                        alert(error_message);
                        error_field.focus();
                        return false;
                    }
                }

                function popupWindow(url) {
                    window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=450,height=280,screenX=150,screenY=150,top=150,left=150')
                }
                //--></script>
            <?php
        }

        if (strstr($PHP_SELF, FILENAME_PRODUCT_REVIEWS_WRITE)) {
            ?>

            <script type="text/javascript"><!--
                function checkForm() {
                    var error = 0;
                    var error_message = unescape("<?php echo vam_js_lang(JS_ERROR); ?>");

                    var review = document.getElementById("product_reviews_write").review.value;

                    if (review.length < <?php echo REVIEW_TEXT_MIN_LENGTH; ?>) {
                        error_message = error_message + unescape("<?php echo vam_js_lang(JS_REVIEW_TEXT); ?>");
                        error = 1;
                    }

                    if (!((document.getElementById("product_reviews_write").rating[0].checked) || (document.getElementById("product_reviews_write").rating[1].checked) || (document.getElementById("product_reviews_write").rating[2].checked) || (document.getElementById("product_reviews_write").rating[3].checked) || (document.getElementById("product_reviews_write").rating[4].checked))) {
                        error_message = error_message + unescape("<?php echo vam_js_lang(JS_REVIEW_RATING); ?>");
                        error = 1;
                    }

                    if (error == 1) {
                        alert(error_message);
                        return false;
                    } else {
                        return true;
                    }
                }
                //--></script>
            <?php
        }
        ?>
<link rel="stylesheet" href="jscript/carousel/skin.css" type="text/css" />
<script src="jscript/carousel/jquery.jcarousel.min.js" type="text/javascript"></script>


<script type="text/javascript">
<?php if (isset($_GET['cat'])) { ?>
	function isScrolledIntoView(elem)
		{
			var docViewTop = $(window).scrollTop();
			var docViewBottom = docViewTop + $(window).height();
		
			var elemTop = $(elem).offset().top;
			var elemBottom = elemTop + $(elem).height();
		
			return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
		}
	jQuery.fn.topLink = function(settings) {
		settings = jQuery.extend({
			min: 1,
			fadeSpeed: 200,
			ieOffset: 50
		}, settings);
		return this.each(function() {
			//listen for scroll
			var el = $(this);
			var footer = $('.footer');
			el.css('display','none'); //in case the user forgot
			$(window).scroll(function() {
				if(!jQuery.support.hrefNormalized) {
					el.css({
						'position': 'absolute',
						'top': $(window).scrollTop() + $(window).height() - settings.ieOffset
					});
				}
				if($(window).scrollTop() >= settings.min)
				{
					/*var scrollBottom = $(document).height() - el.scrollTop() - el.height();*/
					var leftCoord = $(window).width()/2 - 370;
					if ($(window).scrollTop() > ($(document).height() - $(window).height() - footer.height())) {
						el.css('position','absolute');
						el.css('bottom','20px');
						el.css('left','128px');
					} else {
						el.css('position','fixed');
						el.css('bottom','-20px');
						el.css('left',leftCoord+'px');
					}
					el.fadeIn(settings.fadeSpeed);
				}
				else
				{
					el.fadeOut(settings.fadeSpeed);
				}
			});
		});
	};
	
	jQuery(document).ready(function() {
			
			jQuery('#top-link').topLink({
				min: 2000,
				fadeSpeed: 800
			});
			
			//smoothscroll
			jQuery('#top-link').click(function(e) {
				e.preventDefault();
				$.scrollTo(0,1200);
			});
		
			});
		<?php } ?>
			$(document).ready(function() {
									   
					jQuery('#mycarousel').jcarousel({
						wrap: 'circular'
					});
			});
			
		</script>





        <script type="text/javascript" src="jscript/swfobject.js"></script>
        <script type="text/javascript" src="jscript/DoubleTrackBar.js"></script>
        <!--<script type="text/javascript" src="jscript/cusel.js"></script>-->
        <script type="text/javascript" src="jscript/checkbox.js"></script>
        <script type="text/javascript" src="jscript/menu.js"></script>
        <script type="text/javascript" src="jscript/jquery/ui.core.js"></script>
        <script type="text/javascript" src="jscript/jquery/ui.widget.js"></script>
        <script type="text/javascript" src="jscript/jquery/ui.tabs.js"></script>
        <script type="text/javascript" src="jscript/zoom.js"></script>
        <script type="text/javascript" src="jscript/main.js"></script>

        <link type="text/css" href="jscript/slider/advanced-slider.css" rel="Stylesheet">
        <link type="text/css" href="jscript/slider/advanced-slider-themes/dark/advanced-slider.css" rel="Stylesheet">
 
		<script type="text/javascript" src="jscript/slider/advanced-slider.inicialize.js"></script>
		<script type="text/javascript" src="jscript/slider/jquery.advanced-slider.js"></script>


<!--        <script type="text/jCavascript" src="jscript/grayscale.js"></script>
        <link rel="stylesheet" type="text/css" href="jscript/cusel/cusel.css" media="screen" />-->
        <link rel="stylesheet" type="text/css" href="jscript/zoom.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="jscript/2bars/style.css" media="screen" />
        <script type="text/javascript">
		jQuery(document).ready(function(){
					
		<?
		$itemname = 'f8';
		
		$fvals = explode('-', $_GET[$itemname]);
		if ((int) $fvals[0] > 0)
			$fmin = (int) $fvals[0];
		else
			$fmin = 500;
		if ((int) $fvals[1] > 0)
			$fmax = (int) $fvals[1];
		else
			$fmax = 50000;
		echo "setBaseFilter({$fmin},{$fmax},'{$itemname}');";
		?>
		});
		$(window).load(function(){
		//        set_background('<? echo $curbg ?>');
		});
        </script>
        
        
        
   <?php } else { ?>
   
   
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>

        <script type="text/javascript" src="jscript/cookie.js"></script>
        <?php if (AJAX_CART == 'true') { ?>
            <script type="text/javascript" src="jscript/jscript_ajax_cart.js"></script>
        <?php } ?>

        <link rel="stylesheet" type="text/css" href="jscript/jquery/plugins/fancybox/jquery.fancybox-1.2.5.css" media="screen" />
        <script type="text/javascript" src="jscript/jquery/plugins/fancybox/jquery.fancybox-1.2.5.pack.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $("a.zoom").fancybox({
                    "zoomOpacity"			: true,
                    "zoomSpeedIn"			: 500,
                    "zoomSpeedOut"			: 500
                });

                $("a.iframe").fancybox({
                    "padding" : 20, // отступ контента от краев окна
                    "imageScale" : false, // Принимает значение true - контент(изображения) масштабируется по размеру окна, или false - окно вытягивается по размеру контента. По умолчанию - TRUE
                    "zoomOpacity" : true, // изменение прозрачности контента во время анимации (по умолчанию false)
                    "zoomSpeedIn" : 500, // скорость анимации в мс при увеличении фото (по умолчанию 0)
                    "zoomSpeedOut" : 500, // скорость анимации в мс при уменьшении фото (по умолчанию 0)
                    "zoomSpeedChange" : 500, // скорость анимации в мс при смене фото (по умолчанию 0)
                    "frameWidth" : 1000,  // ширина окна, px (425px - по умолчанию)
                    "frameHeight" : 700, // высота окна, px(355px - по умолчанию)
                    "frameScale" : true, // Принимает значение true - контент(изображения) масштабируется по размеру окна, или false - окно вытягивается по размеру контента. По умолчанию - TRUE
                    "overlayShow" : true, // если true затеняят страницу под всплывающим окном. (по умолчанию true). Цвет задается в jquery.fancybox.css - div#fancy_overlay
                    "overlayOpacity" : 0.8,  // Прозрачность затенения  (0.3 по умолчанию)
                    "hideOnContentClick" :true, // Если TRUE  закрывает окно по клику по любой его точке (кроме элементов навигации). Поумолчанию TRUE 
                    "centerOnScroll" : false // Если TRUE окно центрируется на экране, когда пользователь прокручивает страницу 
                });
	
            });
                                        
        </script>




			<script type="text/javascript">
            
        $(function () {
        
            $('.q').hover(
        
        
        
        function ()
            {
            $(this).children('.to').css("display", "inline");
            }
        ,
        
        
        function ()
            {
            $(this).children('.to').css("display", "none");
            }
        
        
        
        );
        
        });
        


        </script>


        <?php
		// require theme based javascript
        require('templates/' . CURRENT_TEMPLATE . '/javascript/general.js.php');

        if (strstr($PHP_SELF, FILENAME_CHECKOUT_PAYMENT)) {
            echo $payment_modules->javascript_validation();
        }

        if (strstr($PHP_SELF, FILENAME_CREATE_ACCOUNT)) {
            require(DIR_WS_INCLUDES . 'form_check.js.php');
        }

        if (strstr($PHP_SELF, FILENAME_CHECKOUT_ALTERNATIVE)) {
            require(DIR_WS_INCLUDES . 'form_check.js.php');
        }

        if (strstr($PHP_SELF, FILENAME_CREATE_GUEST_ACCOUNT)) {
            require(DIR_WS_INCLUDES . 'form_check.js.php');
        }
        if (strstr($PHP_SELF, FILENAME_ACCOUNT_PASSWORD)) {
            require(DIR_WS_INCLUDES . 'form_check.js.php');
        }
        if (strstr($PHP_SELF, FILENAME_ACCOUNT_EDIT)) {
            require(DIR_WS_INCLUDES . 'form_check.js.php');
        }
        if (strstr($PHP_SELF, FILENAME_ADDRESS_BOOK_PROCESS)) {
            if (isset($_GET['delete']) == false) {
                include(DIR_WS_INCLUDES . 'form_check.js.php');
            }
        }
        if (strstr($PHP_SELF, FILENAME_CHECKOUT_PAYMENT)) {
            require(DIR_WS_INCLUDES . 'form_check.js.php');
        }
        if (strstr($PHP_SELF, FILENAME_CHECKOUT_SHIPPING_ADDRESS) or strstr($PHP_SELF, FILENAME_CHECKOUT_PAYMENT_ADDRESS)) {
            require(DIR_WS_INCLUDES . 'form_check.js.php');
            ?>
            <script type="text/javascript"><!--
                function check_form_optional(form_name) {
                    var form = form_name;

                    var firstname = form.elements['firstname'].value;
                    var lastname = form.elements['lastname'].value;
                    var street_address = form.elements['street_address'].value;

                    if (firstname == '' && lastname == '' && street_address == '') {
                        return true;
                    } else {
                        return check_form(form_name);
                    }
                }
                //--></script>
            <?php
        }

        if (strstr($PHP_SELF, FILENAME_ADVANCED_SEARCH)) {
            ?>
            <script type="text/javascript" src="includes/general.js"></script>
            <script type="text/javascript"><!--
                function check_form() {
                    var error_message = unescape("<?php echo vam_js_lang(JS_ERROR); ?>");
                    var error_found = false;
                    var error_field;
                    var keywords = document.getElementById("advanced_search").keywords.value;
                    var pfrom = document.getElementById("advanced_search").pfrom.value;
                    var pto = document.getElementById("advanced_search").pto.value;
                    var pfrom_float;
                    var pto_float;

                    if ( (keywords == '' || keywords.length < 1) && (pfrom == '' || pfrom.length < 1) && (pto == '' || pto.length < 1) ) {
                        error_message = error_message + unescape("<?php echo vam_js_lang(JS_AT_LEAST_ONE_INPUT); ?>");
                        error_field = document.getElementById("advanced_search").keywords;
                        error_found = true;
                    }

                    if (pfrom.length > 0) {
                        pfrom_float = parseFloat(pfrom);
                        if (isNaN(pfrom_float)) {
                            error_message = error_message + unescape("<?php echo vam_js_lang(JS_PRICE_FROM_MUST_BE_NUM); ?>");
                            error_field = document.getElementById("advanced_search").pfrom;
                            error_found = true;
                        }
                    } else {
                        pfrom_float = 0;
                    }

                    if (pto.length > 0) {
                        pto_float = parseFloat(pto);
                        if (isNaN(pto_float)) {
                            error_message = error_message + unescape("<?php echo vam_js_lang(JS_PRICE_TO_MUST_BE_NUM); ?>");
                            error_field = document.getElementById("advanced_search").pto;
                            error_found = true;
                        }
                    } else {
                        pto_float = 0;
                    }

                    if ( (pfrom.length > 0) && (pto.length > 0) ) {
                        if ( (!isNaN(pfrom_float)) && (!isNaN(pto_float)) && (pto_float < pfrom_float) ) {
                            error_message = error_message + unescape("<?php echo vam_js_lang(JS_PRICE_TO_LESS_THAN_PRICE_FROM); ?>");
                            error_field = document.getElementById("advanced_search").pto;
                            error_found = true;
                        }
                    }

                    if (error_found == true) {
                        alert(error_message);
                        error_field.focus();
                        return false;
                    }
                }

                function popupWindow(url) {
                    window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=450,height=280,screenX=150,screenY=150,top=150,left=150')
                }
                //--></script>
            <?php
        }

        if (strstr($PHP_SELF, FILENAME_PRODUCT_REVIEWS_WRITE)) {
            ?>

            <script type="text/javascript"><!--
                function checkForm() {
                    var error = 0;
                    var error_message = unescape("<?php echo vam_js_lang(JS_ERROR); ?>");

                    var review = document.getElementById("product_reviews_write").review.value;

                    if (review.length < <?php echo REVIEW_TEXT_MIN_LENGTH; ?>) {
                        error_message = error_message + unescape("<?php echo vam_js_lang(JS_REVIEW_TEXT); ?>");
                        error = 1;
                    }

                    if (!((document.getElementById("product_reviews_write").rating[0].checked) || (document.getElementById("product_reviews_write").rating[1].checked) || (document.getElementById("product_reviews_write").rating[2].checked) || (document.getElementById("product_reviews_write").rating[3].checked) || (document.getElementById("product_reviews_write").rating[4].checked))) {
                        error_message = error_message + unescape("<?php echo vam_js_lang(JS_REVIEW_RATING); ?>");
                        error = 1;
                    }

                    if (error == 1) {
                        alert(error_message);
                        return false;
                    } else {
                        return true;
                    }
                }
                //--></script>
            <?php
        }
        ?>
        <link rel="stylesheet" href="jscript/carousel/skin.css" type="text/css" />
        <script src="jscript/carousel/jquery.jcarousel.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="jscript/jquery.scrollTo-1.4.0-min.js"></script>
        
        <script type="text/javascript">
        <?php if (isset($_GET['cat'])) { ?>
		function isScrolledIntoView(elem)
		{
			var docViewTop = $(window).scrollTop();
			var docViewBottom = docViewTop + $(window).height();
		
			var elemTop = $(elem).offset().top;
			var elemBottom = elemTop + $(elem).height();
		
			return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
		}
		jQuery.fn.topLink = function(settings) {
		settings = jQuery.extend({
			min: 1,
			fadeSpeed: 200,
			ieOffset: 50
		}, settings);
		return this.each(function() {
			//listen for scroll
			var el = $(this);
			var footer = $('.footer');
			el.css('display','none'); //in case the user forgot
			$(window).scroll(function() {
				if(!jQuery.support.hrefNormalized) {
					el.css({
						'position': 'absolute',
						'top': $(window).scrollTop() + $(window).height() - settings.ieOffset
					});
				}
				if($(window).scrollTop() >= settings.min)
				{
					/*var scrollBottom = $(document).height() - el.scrollTop() - el.height();*/
					var leftCoord = $(window).width()/2 - 370;
					if ($(window).scrollTop() > ($(document).height() - $(window).height() - footer.height())) {
						el.css('position','absolute');
						el.css('bottom','20px');
						el.css('left','128px');
					} else {
						el.css('position','fixed');
						el.css('bottom','-20px');
						el.css('left',leftCoord+'px');
					}
					el.fadeIn(settings.fadeSpeed);
				}
				else
				{
					el.fadeOut(settings.fadeSpeed);
				}
			});
		});
	};
	
		jQuery(document).ready(function() {
			
			jQuery('#top-link').topLink({
				min: 2000,
				fadeSpeed: 800
			});
			
			//smoothscroll
			jQuery('#top-link').click(function(e) {
				e.preventDefault();
				$.scrollTo(0,1200);
			});
		
			});
		<?php } ?>
		$(document).ready(function() {
								   
				jQuery('#mycarousel').jcarousel({
					wrap: 'circular'
				});
		});
	
        </script>


        <link rel="stylesheet" href="jscript/selectbox/selectbox.css" type="text/css">

        <script type="text/javascript" src="jscript/selectbox/jquery.selectbox.min.js"></script>
        
        <script>
            (function($) {
                $(function() {
                    $('select').selectbox();
                })
            })(jQuery)
        </script>


        <script type="text/javascript" src="jscript/swfobject.js"></script>
        <script type="text/javascript" src="jscript/DoubleTrackBar.js"></script>
        <script type="text/javascript" src="jscript/cusel.js"></script>
        <script type="text/javascript" src="jscript/checkbox.js"></script>
        <script type="text/javascript" src="jscript/menu.js"></script>
        <script type="text/javascript" src="jscript/jquery/ui.core.js"></script>
        <script type="text/javascript" src="jscript/jquery/ui.widget.js"></script>
        <script type="text/javascript" src="jscript/jquery/ui.tabs.js"></script>
        <script type="text/javascript" src="jscript/zoom.js"></script>
        <script type="text/javascript" src="jscript/main.js"></script>

        <link type="text/css" href="jscript/slider/advanced-slider.css" rel="Stylesheet">
        <link type="text/css" href="jscript/slider/advanced-slider-themes/dark/advanced-slider.css" rel="Stylesheet">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js"></script>
        <script type="text/javascript" src="jscript/slider/advanced-slider.inicialize.js"></script>
        <script type="text/javascript" src="jscript/slider/jquery.advanced-slider.js"></script>


<!--        <script type="text/jCavascript" src="jscript/grayscale.js"></script>-->
        <link rel="stylesheet" type="text/css" href="jscript/cusel/cusel.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="jscript/zoom.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="jscript/2bars/style.css" media="screen" />
        <script type="text/javascript">
		jQuery(document).ready(function(){
					
		<?
		$itemname = 'f8';
		
		$fvals = explode('-', $_GET[$itemname]);
		if ((int) $fvals[0] > 0)
			$fmin = (int) $fvals[0];
		else
			$fmin = 500;
		if ((int) $fvals[1] > 0)
			$fmax = (int) $fvals[1];
		else
			$fmax = 50000;
		echo "setBaseFilter({$fmin},{$fmax},'{$itemname}');";
		?>
		});
		$(window).load(function(){
		//        set_background('<? echo $curbg ?>');
		});
			</script>
   
   
   <?php } ?>
   
   
    </head>
    <body<?php if ($_SERVER['PHP_SELF'] !== '/product_reviews_write.php' && $_SERVER['PHP_SELF'] !== '/size_chart.php' && $_SERVER['PHP_SELF'] !== '/ask_a_question.php') { echo ' class="bg"'; } ?>>
        <?php 
        if (!strstr($PHP_SELF, FILENAME_CHECKOUT_SUCCESS)) {
            require(DIR_WS_INCLUDES . 'google_conversiontracking.js.php');
        }
        ?>
        <?php
        // include needed functions
        require_once(DIR_FS_INC . 'vam_output_warning.inc.php');
        require_once(DIR_FS_INC . 'vam_image.inc.php');
        require_once(DIR_FS_INC . 'vam_parse_input_field_data.inc.php');
        require_once(DIR_FS_INC . 'vam_draw_separator.inc.php');

//  require_once('inc/vam_draw_form.inc.php');
//  require_once('inc/vam_draw_pull_down_menu.inc.php');
        // check if the 'install' directory exists, and warn of its existence
        if (WARN_INSTALL_EXISTENCE == 'true') {
            if (file_exists(dirname($_SERVER['SCRIPT_FILENAME']) . '/install')) {
                vam_output_warning(WARNING_INSTALL_DIRECTORY_EXISTS);
            }
        }

        // check if the configure.php file is writeable
        if (WARN_CONFIG_WRITEABLE == 'true') {
            if ((file_exists(dirname($_SERVER['SCRIPT_FILENAME']) . '/includes/configure.php')) && (is_writeable(dirname($_SERVER['SCRIPT_FILENAME']) . '/includes/configure.php'))) {

                vam_output_warning(WARNING_CONFIG_FILE_WRITEABLE);
            }
        }

        if ((!file_exists(dirname($_SERVER['SCRIPT_FILENAME']) . '/vamshop.key')) && (!file_exists(dirname($_SERVER['SCRIPT_FILENAME']) . '/vamshop.key.txt'))) {

            vam_output_warning(WARNING_VAMSHOP_KEY);
        }

        // check if the session folder is writeable
        if (WARN_SESSION_DIRECTORY_NOT_WRITEABLE == 'true') {
            if (STORE_SESSIONS == '') {
                if (!is_dir(vam_session_save_path())) {
                    vam_output_warning(WARNING_SESSION_DIRECTORY_NON_EXISTENT);
                } elseif (!is_writeable(vam_session_save_path())) {
                    vam_output_warning(WARNING_SESSION_DIRECTORY_NOT_WRITEABLE);
                }
            }
        }

        // check session.auto_start is disabled
        if ((function_exists('ini_get')) && (WARN_SESSION_AUTO_START == 'true')) {
            if (ini_get('session.auto_start') == '1') {
                vam_output_warning(WARNING_SESSION_AUTO_START);
            }
        }

        if ((WARN_DOWNLOAD_DIRECTORY_NOT_READABLE == 'true') && (DOWNLOAD_ENABLED == 'true')) {
            if (!is_dir(DIR_FS_DOWNLOAD)) {
                vam_output_warning(WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT);
            }
        }


        $vamTemplate->assign('navtrail', $breadcrumb->trail(' &raquo; '));
        if (isset($_SESSION['customer_id'])) {

            $vamTemplate->assign('logoff', vam_href_link(FILENAME_LOGOFF, '', 'SSL'));
        }
        if ($_SESSION['account_type'] == '0') {
            $vamTemplate->assign('account', vam_href_link(FILENAME_ACCOUNT, '', 'SSL'));
        }
        $vamTemplate->assign('cart', vam_href_link(FILENAME_SHOPPING_CART, '', 'SSL'));
        $vamTemplate->assign('checkout', vam_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
        $vamTemplate->assign('store_name', TITLE);
        $vamTemplate->assign('login', vam_href_link(FILENAME_LOGIN, '', 'SSL'));
        $vamTemplate->assign('mainpage', HTTP_SERVER . DIR_WS_CATALOG);



        if (isset($_GET['error_message']) && vam_not_null($_GET['error_message'])) {

            $vamTemplate->assign('error', '
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr class="headerError">
        <td class="headerError">' . htmlspecialchars(urldecode($_GET['error_message'])) . '</td>
      </tr>
    </table>');
        }

        if (isset($_GET['info_message']) && vam_not_null($_GET['info_message'])) {

            $vamTemplate->assign('error', '
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr class="headerInfo">
        <td class="headerInfo">' . htmlspecialchars($_GET['info_message']) . '</td>
      </tr>
    </table>');
        }

// Метки для закладок

        if (strstr($PHP_SELF, FILENAME_DEFAULT)) {
            $vamTemplate->assign('1', ' class="current"');
        }

        if (strstr($PHP_SELF, FILENAME_ACCOUNT) or strstr($PHP_SELF, FILENAME_ACCOUNT_EDIT) or strstr($PHP_SELF, FILENAME_ADDRESS_BOOK) or strstr($PHP_SELF, FILENAME_ADDRESS_BOOK_PROCESS) or strstr($PHP_SELF, FILENAME_ACCOUNT_HISTORY) or strstr($PHP_SELF, FILENAME_ACCOUNT_HISTORY_INFO) or strstr($PHP_SELF, FILENAME_ACCOUNT_PASSWORD) or strstr($PHP_SELF, FILENAME_NEWSLETTER)) {
            $vamTemplate->assign('2', ' class="current"');
        }

        if (strstr($PHP_SELF, FILENAME_SHOPPING_CART)) {
            $vamTemplate->assign('3', ' class="current"');
        }

        if (strstr($PHP_SELF, FILENAME_CHECKOUT_SHIPPING) or strstr($PHP_SELF, FILENAME_CHECKOUT_PAYMENT) or strstr($PHP_SELF, FILENAME_CHECKOUT_CONFIRMATION) or strstr($PHP_SELF, FILENAME_CHECKOUT_SUCCESS)) {
            $vamTemplate->assign('4', ' class="current"');
        }

        if (strstr($PHP_SELF, FILENAME_LOGOFF)) {
            $vamTemplate->assign('5', ' class="current"');
        }

        if (strstr($PHP_SELF, FILENAME_LOGIN)) {
            $vamTemplate->assign('6', ' class="current"');
        }


// /Метки для закладок

        include(DIR_WS_INCLUDES . FILENAME_BANNER);
        ?>