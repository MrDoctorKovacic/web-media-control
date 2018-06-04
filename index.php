<!DOCTYPE html>
<!-- Templated From https://startbootstrap.com/template-overviews/bare/ -->
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Media Controller</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <style>
      body {
        padding-top: 54px;
        position: absolute;
        width: 100%;
        height: 100%;
        background-color: #0a0a0a;
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        color: #fff;
      }
      body:after {
        content:"";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.3);
        z-index: -1;
      }
      h1, p {
        font-size: 3.5em;
      }
      .center-absolute {
        text-align: center!important;
        position: absolute;
        top: 40%;
        transform: translateY(-50%);
        left: 0;
      }
      #artist {
        font-style: italics;
      }
      @media (min-width: 992px) {
        body {
          padding-top: 56px;
        }
      }

    </style>

  </head>

  <body>

    <!-- Page Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center center-absolute">
          <h1 id="title">Nothing Playing</h1>
          <p class="lead" id="artist"></p>
          <button id="testBtn"></button>
        </div>
      </div>
      <div class="row hidden" id="console">
        <div class="col-lg-12 console-holder">
          <p></p>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script>
      var album = "";
      var artist = "";

      setInterval(triggerSongUpdate, 1000);

      // Force update before interval
      jQuery("#testBtn").on("click", function() {
        triggerSongUpdate();
      });

      // Get song info
      function triggerSongUpdate() {
        $.getJSON('media.php', function(data) {
          updateSongInfo(data);
        });
      }

      // Update UI with media object info
      function updateSongInfo(mediaObject) {
        console.log(mediaObject);
        if(mediaObject["Artist"] !== artist || mediaObject["Album"] !== album) {
          console.log("Refreshing Album Artwork");
          getAlbumArtwork(mediaObject["Album"], mediaObject["Artist"]);
        }

        album = mediaObject["Album"];
        artist = mediaObject["Artist"];
        jQuery("#title").text(mediaObject["Title"]);
        jQuery("#artist").text(mediaObject["Artist"]);
      }

      // Update album artwork. Adapted from aybalasubramanian's fiddle 
      // http://jsfiddle.net/aybalasubramanian/zpdseds7/
      function getAlbumArtwork(album, artist) {
        var searchQuery = album+" "+artist+" cover";
        console.log(searchQuery);
        $.ajax({
            type: "GET",
            dataType: "jsonp",
            url: "https://www.googleapis.com/customsearch/v1",
            data: {
                key: "AIzaSyCzb6SI_JRrp6xLLYV617Ary6n59h36ros",
                cx: "004286675445984025592:ypgpkv9fjd4",
                filter: "1",
                searchType: "image",
                q: searchQuery
            }, async: false
        }).done(function(data) {
            console.log(data);
            var googleResults = data.items;
            itemIndex = 0;
            $("body").css("background-image", "url("+data.items[itemIndex].link+")");
        });
    }
    </script>

  </body>

</html>
