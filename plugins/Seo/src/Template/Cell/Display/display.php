<?php
	use Cake\Routing\Router;
	$current_url = Router::url('/',true);
	$site_name = $this->Query->info('name');
	$site_desc = $this->Query->info('description');
	$site_url = $this->Query->info('siteurl');
	global $result;
	global $is_status;
	$image = $this->Func->OptionGet('site_favicon');
	$lang = $this->Func->OptionGet('lang_name');
	$title = $site_name;

	if($is_status == 'single'){
		if(($tit = $this->Query->the_title()) != '')
			$title = $this->Query->the_title();

		if(($desc = $this->Query->the_excerpt()) != '')
			$site_desc = str_replace(array("\r", "\n"), '', strip_tags($desc));;

		if(($url = $this->Query->the_permalink()) != '')
			$site_url = $url;

		if(($img = $this->Query->the_image(['size'=>'medium'])) != '') 
			$image = $img;		
	}
	
	if(isset($opt['autossl']) and $opt['autossl'] == 1){
		$image = str_replace('http','https',Router::url($image,true));
		$site_url = str_replace('http','https',Router::url($site_url,true));
	}
	else{
		$image = Router::url($image,true);
		$site_url = Router::url($site_url,true);
	}?>
	<link rel="canonical" href="<?= $site_url?>" />
	<meta name="title" content="<?=$title?>">
	<meta name="description" content="<?=$this->Query->info('description')?>">
	<meta itemprop="name" content="<?=$site_name?>">
	<meta itemprop="description" content="<?=$site_desc;?>">
	<meta itemprop="image" content="<?= $image?>">
    <meta property="og:site_name" content="<?=$site_name?>">
    <meta property="og:title" content="<?=$title?>">
    <meta property="og:description" content="<?=$site_desc;?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= $site_url;?>">
    <meta property="og:image" content="<?= $image?>">
	<meta property="og:image:width" content="400" />
	<meta property="og:image:height" content="300" />
    <meta property="og:locale" content="<?=$lang ?>">

	<!-- Twitter Cards
	Will generate a card based on the info below.
	More here: https://davidwalsh.name/twitter-cards or https://dev.twitter.com/docs/cards -->
	<meta name="twitter:card" content="<?=$site_desc;?>">
	<meta name="twitter:image" content="<?= $image?>">
	<meta name="twitter:domain" content="<?=$site_url;?>">
	<meta name="twitter:site" content="<?= $site_url;?>">
	<meta name="twitter:creator" content="<?= $site_url;?>">
	<meta name="twitter:url" content="<?=$site_url;?>">
	<meta name="twitter:title" content="<?=$title?>">
	<meta name="twitter:description" content="<?=$site_desc;?>">
	<meta name="robots" content="all">

	<?php /*<!-- GeoLocation Meta Tags / Geotagging. Used for custom results in Google.
	Generator here https://mygeoposition.com/ 
	<meta name="geo.placename" content="Chicago, IL, USA" />
	<meta name="geo.position" content="41.8781140;-87.6297980" />
	<meta name="geo.region" content="US-Illinois" />
	<meta name="ICBM" content="41.8781140, -87.6297980" />
	-->*/?>

	<link rel="schema.DC" href="https://purl.org/DC/elements/1.0/" />
	<meta name="DC.Title" content="<?=$site_name?>" />
	<meta name="DC.Format" content="text/html" />
	<meta name="DC.Language" content="<?=$lang ?>" />
	<meta name="DC.Type" content="software" />
	<meta name="DC.Date" content="<?=date('Y-m-d')?>" />
	
	<?php /*<meta name="DC.Creator" content="hogash" />
	<!-- Retina Images -->
	<!-- Simply uncomment to use this script !! More here https://retina-images.complexcompulsions.com/
	<script>(function(w){var dpr=((w.devicePixelRatio===undefined)?1:w.devicePixelRatio);if(!!w.navigator.standalone){var r=new XMLHttpRequest();r.open('GET','/retinaimages.php?devicePixelRatio='+dpr,false);r.send()}else{document.cookie='devicePixelRatio='+dpr+'; path=/'}})(window)</script>
	<noscript><style id="devicePixelRatio" media="only screen and (-moz-min-device-pixel-ratio: 2), only screen and (-o-min-device-pixel-ratio: 2/1), only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min-device-pixel-ratio: 2)">html{background-image:url("php-helpers/_retinaimages.php?devicePixelRatio=2")}</style></noscript>-->
	<!-- End Retina Images -->

	<div itemscope itemtype="http://schema.org/Person">
		<span itemprop="name">Joe Doe</span>
		<span itemprop="company">The Example Company</span>
		<span itemprop="tel">604-555-1234</span>
		<a itemprop="email" href="mailto:joe.doe@example.com">joe.doe@example.com</a>
	</div> 
	*/?>

	<!-- iDevices & Retina Favicons -->
	<link rel="apple-touch-icon-precomposed" type="image/x-icon" href="<?= isset($opt['fav_72_72'])?$opt['fav_72_72']:'' ?>" sizes="72x72" />
	<link rel="apple-touch-icon-precomposed" type="image/x-icon" href="<?= isset($opt['fav_114_114'])?$opt['fav_114_114']:'' ?>" sizes="114x114" />
	<link rel="apple-touch-icon-precomposed" type="image/x-icon" href="<?= isset($opt['fav_144_144'])?$opt['fav_144_144']:'' ?>" sizes="144x144" />
	<link rel="apple-touch-icon-precomposed" type="image/x-icon" href="<?= isset($opt['fav_default'])?$opt['fav_default']:'' ?>" />

	
<?php if(isset($opt['google_analytics']) and $opt['google_analytics'] != ''):?>
	<!-- Google Analytics -->
	<script nonce="<?=get_nonce?>">
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	ga('create', <?=$opt['google_analytics']?>, 'auto');
	ga('send', 'pageview');
	</script>
	<!-- End Google Analytics -->
<?php endif;

if(isset($opt['alexa']) and $opt['alexa'] != ''):?>
	<!-- Start Alexa Certify Javascript -->
	<script nonce="<?=get_nonce?>" type="text/javascript">
		_atrk_opts = {atrk_acct: "XXXXX", domain: "XXXX.com", dynamic: true};
		(function () {
			var as = document.createElement('script');
			as.type = 'text/javascript';
			as.async = true;
			as.src = "https://certify-js.alexametrics.com/atrk.js";
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(as, s);
		})();
	</script>
	<!-- End Alexa Certify Javascript -->
<?php endif;

if(isset($opt['google_tag']) and $opt['google_tag'] != ''):?>
	<!-- Google Tag Manager -->
	<script nonce="<?=get_nonce?>">(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
				new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
			j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
			'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer',<?=$opt['google_tag'];//'GTM-XXXXXX'?>);</script>
	<!-- End Google Tag Manager -->	

	<?php /* <script async src="https://www.googletagmanager.com/gtag/js?id=UA-XXXX-1"></script>
	<script nonce="<?=get_nonce?>">
		window.dataLayer = window.dataLayer || [];
		function gtag() {dataLayer.push(arguments);}
		window.emarsysCategoryBreadcrumb=window.emarsysCategoryBreadcrumb||"";var GTMurl=document.location.href,dataGTM="";"/"===document.location.pathname?dataGTM="HOME":1<GTMurl.indexOf("/users")?dataGTM=1<GTMurl.indexOf("/login")?"LOGIN":1<GTMurl.indexOf("/register")?"REGISTER":"USERS":1<GTMurl.indexOf("/product-list")?dataGTM="PRODUCT-LIST":1<GTMurl.indexOf("/profile/")?dataGTM="PROFILE":1<GTMurl.indexOf("/page/")?dataGTM="STATIC-PAGE":1<GTMurl.indexOf("/brand")?dataGTM="BRAND":1<GTMurl.indexOf("/seller")?dataGTM="SELLER":1<GTMurl.indexOf("/product")?dataGTM="PDP":1<GTMurl.indexOf("/cart")?dataGTM="CART":1<GTMurl.indexOf("/shipping")?dataGTM="CHECKOUT - Shipping":1<GTMurl.indexOf("/checkout")||1<GTMurl.lastIndexOf("/cash-on-delivery")?dataGTM="THANKYOUPAGE":1<GTMurl.indexOf("/payment/")?dataGTM="CHECKOUT - Payment":1<GTMurl.indexOf("/landing-page")?dataGTM="LANDING PAGES":1<GTMurl.indexOf("/compare")?dataGTM="COMPARE":1<GTMurl.indexOf("/search")?dataGTM=1<GTMurl.indexOf("q=")?1<GTMurl.indexOf("entry=mm")?"megamenu":"SEARCH":"PLP":1<GTMurl.indexOf("main")?dataGTM="CMP":1<GTMurl.indexOf("/incredible-offers")?dataGTM="INCREDIBLE OFFER":1<GTMurl.indexOf("/my-digikala")?dataGTM="MYDIGIKAL":1<GTMurl.indexOf("/promotion-page/")&&(dataGTM="PROMOTION");
		dataLayer.push({
			"pageCategory": [dataGTM]
		});
		gtag('js', new Date());
		if(!window.module_GTM_demo) {
			gtag('config', 'UA-XXXXXXXX-1', { 'send_page_view': false });
		}
	</script> */?>
	
<?php endif;

if(isset($opt['js_header']) and $opt['js_header'] != ''):
	echo $opt['js_header'];
endif;?>