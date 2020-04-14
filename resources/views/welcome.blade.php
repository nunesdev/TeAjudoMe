<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
      <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no, shrink-to-fit=no">
        <meta charset="utf-8">
        <meta property="og:title" content="TeAjudo - Plataforma colaborativa">
        <meta property="og:description" content="Plataforma colaborativa criada para ajudar pessoas com a pandemia COVID-19">
        <meta property="og:image" content="https://teajudo.me/images/teajudome.png">
        <meta property="og:url" content="https://www.teajudo.me">

        <meta name="twitter:title" content="TeAjudo - Plataforma colaborativa ">
        <meta name="twitter:description" content="Plataforma colaborativa criada para ajudar pessoas com a pandemia COVID-19">
        <meta name="twitter:image" content="https://teajudo.me/images/teajudome.png">
        <meta name="twitter:card" content="summary_large_image">

        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-title" content="Te Ajudo">
        <meta name="application-name" content="Te Ajudo" />
        <meta name="apple-touch-fullscreen" content="yes" />

        <meta name="theme-color" content="#264463">
        <meta name="msapplication-navbutton-color" content="#264463">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <meta name="msapplication-starturl" content="/?utm_source=homescreen">
        <meta name="msapplication-TileColor" content="#264463">

        <link rel="icon" type="image/png" sizes="72x72" href="/images/icons/icon-72x72.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/images/icons/icon-96x96.png">
        <link rel="icon" type="image/png" sizes="128x128" href="/images/icons/icon-128x128.png">
        <link rel="icon" type="image/png" sizes="144x144" href="/images/icons/icon-144x144.png">
        <link rel="icon" type="image/png" sizes="152x152" href="/images/icons/icon-152x152.png">
        <link rel="icon" type="image/png" sizes="192x192" href="/images/icons/icon-192x192.png">
        <link rel="icon" type="image/png" sizes="384x384" href="/images/icons/icon-384x384.png">
        <link rel="icon" type="image/png" sizes="512x512" href="/images/icons/icon-512x512.png">
        <link rel="apple-touch-icon" type="image/png" sizes="180x180" href="/images/icons/apple/icon-180x180.png">

        <link  rel="apple-touch-startup-image" href="/images/icons/splash/iphone5_splash.png" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" />
        <link  rel="apple-touch-startup-image" href="/images/icons/splash/iphone6_splash.png" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" />
        <link  rel="apple-touch-startup-image" href="/images/icons/splash/iphoneplus_splash.png" media="(device-width: 621px) and (device-height: 1104px) and (-webkit-device-pixel-ratio: 3)" />
        <link  rel="apple-touch-startup-image" href="/images/icons/splash/iphonex_splash.png" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)" />
        <link  rel="apple-touch-startup-image" href="/images/icons/splash/iphonexr_splash.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)" />
        <link  rel="apple-touch-startup-image" href="/images/icons/splash/iphonexsmax_splash.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)" />
        <link  rel="apple-touch-startup-image" href="/images/icons/splash/ipad_splash.png" media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)" />
        <link  rel="apple-touch-startup-image" href="/images/icons/splash/ipadpro1_splash.png" media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)" />
        <link  rel="apple-touch-startup-image" href="/images/icons/splash/ipadpro3_splash.png" media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)" />
        <link  rel="apple-touch-startup-image" href="/images/icons/splash/ipadpro2_splash.png" media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)" />

        <link rel="manifest" href="/manifest.json?c=1">

        <title>Te Ajudo - Me</title>
        <!-- Fonts -->
        <!-- <link href="https://api.tiles.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.css" rel="stylesheet"/> -->
        <link
        rel="stylesheet"
        href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.4.2/mapbox-gl-geocoder.css"
        type="text/css"
        />
        <link href="https://api.mapbox.com/mapbox-gl-js/v1.9.0/mapbox-gl.css" rel="stylesheet" />
        <link href="//fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="/css/app.css?c=15">
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:1752370,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
  var OneSignal = window.OneSignal || [];
  OneSignal.push(function() {
    OneSignal.init({
      appId: window.location.host.includes('dev') ? "7b37bf81-b1d0-4303-89bd-04a223cece62" : "157b4f4f-3001-4ad3-93f8-8bdf9970e51c", // prod
    });
  });
  window.INSTALLAPPEVENT = false;
  window.addEventListener('beforeinstallprompt', (event) => {
    event.preventDefault();
    window.INSTALLAPPEVENT = event;
    console.log('Can install App',window.INSTALLAPPEVENT);
  });
</script>
    </head>
    <body >
      <div id="app"></div>
      <script type="text/javascript" src="/js/app.js?c=15"></script>
    </body>
</html>
