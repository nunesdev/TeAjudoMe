<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta property="og:title" content="TeAjudo - Plataforma colaborativa">
        <meta property="og:description" content="Plataforma colaborativa criada para ajudar pessoas com a pandemia COVID-19">
        <meta property="og:image" content="https://teajudo.me/images/teajudome.png">
        <meta property="og:url" content="https://www.teajudo.me">

        <meta name="twitter:title" content="TeAjudo - Plataforma colaborativa ">
        <meta name="twitter:description" content="Plataforma colaborativa criada para ajudar pessoas com a pandemia COVID-19">
        <meta name="twitter:image" content="https://teajudo.me/images/teajudome.png">
        <meta name="twitter:card" content="summary_large_image">

        <link rel="manifest" href="manifest.json">

        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="application-name" content="teajudo">
        <meta name="apple-mobile-web-app-title" content="teajudo">
        <meta name="theme-color" content="#264463">
        <meta name="msapplication-navbutton-color" content="#264463">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="msapplication-starturl" content="/">

        <link rel="icon" type="image/png" sizes="72x72" href="images/icons/icon-72x72.png">
        <link rel="apple-touch-icon" type="image/png" sizes="72x72" href="images/icons/apple/icon-72x72.png">
        <link rel="icon" type="image/png" sizes="96x96" href="images/icons/icon-96x96.png">
        <link rel="apple-touch-icon" type="image/png" sizes="96x96" href="images/icons/apple/icon-96x96.png">
        <link rel="icon" type="image/png" sizes="128x128" href="mages/icons/icon-128x128.png">
        <link rel="apple-touch-icon" type="image/png" sizes="128x128" href="mages/icons/apple/icon-128x128.png">
        <link rel="icon" type="image/png" sizes="144x144" href="images/icons/icon-144x144.png">
        <link rel="apple-touch-icon" type="image/png" sizes="144x144" href="images/icons/apple/icon-144x144.png">
        <link rel="icon" type="image/png" sizes="152x152" href="images/icons/icon-152x152.png">
        <link rel="apple-touch-icon" type="image/png" sizes="152x152" href="images/icons/apple/icon-152x152.png">
        <link rel="icon" type="image/png" sizes="192x192" href="images/icons/icon-192x192.png">
        <link rel="apple-touch-icon" type="image/png" sizes="192x192" href="images/icons/apple/icon-192x192.png">
        <link rel="icon" type="image/png" sizes="384x384" href="images/icons/icon-384x384.png">
        <link rel="apple-touch-icon" type="image/png" sizes="384x384" href="images/icons/apple/icon-384x384.png">
        <link rel="icon" type="image/png" sizes="512x512" href="images/icons/icon-512x512.png">
        <link rel="apple-touch-icon" type="image/png" sizes="512x512" href="images/icons/apple/icon-512x512.png">

        <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no, shrink-to-fit=no">
        <title>Te Ajudo - Me</title>
        <!-- Fonts -->
        <!-- <link href="https://api.tiles.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.css" rel="stylesheet"/> -->
        <link href="https://api.mapbox.com/mapbox-gl-js/v1.9.0/mapbox-gl.css" rel="stylesheet" />
        <link href="//fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="/css/app.css?c=4">
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
      // appId: "7b37bf81-b1d0-4303-89bd-04a223cece62", //dev
      appId: "157b4f4f-3001-4ad3-93f8-8bdf9970e51c", // prod
    });
  });
</script>
    </head>
    <body >
      <div id="app"></div>
      <script type="text/javascript">
      window.addEventListener('load', () => {
        if (navigator.standalone) {
          console.log('Launched: Installed (iOS)');
        } else if (matchMedia('(display-mode: standalone)').matches) {
          console.log('Launched: Installed');
        } else {
          console.log('Launched: Browser Tab');
        }
      });

      window.addEventListener('beforeinstallprompt', (event) => {
        event.preventDefault();
        window.INSTALLAPPEVENT = event;
        console.log('Can install App',event);
      });
      </script>
      <script type="text/javascript" src="/js/app.js?c=4"></script>
    </body>
</html>
