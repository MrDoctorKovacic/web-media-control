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
    <link href="vendor/font-awesome/css/fontawesome-all.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <style>
      body {
        padding-top: 54px;
        position: absolute;
        width: 100%;
        height: 100%;
        background-color: #0a0a0a;
        background-size: cover;
        background-position: top;
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
        background-color: rgba(0, 0, 0, 0.5);
        z-index: -1;
      }
      h1, p.lead {
        font-size: 4.5em;
      }
      .center-absolute {
        text-align: center !important;
        position: absolute;
        top: 50%;
        transform: translate(-50%, -50%);
        left: 50%;
        width: 100%;
      }
      #artist {
        font-style: italics;
        margin-bottom: 40px;
      }
      @media (min-width: 992px) {
        body {
          padding-top: 56px;
        }
      }

      .push {
        padding: 30px;
      }
      .pushed{
        animation: push .5s ease-in 1;
      }
      @keyframes push{
        50%  {transform: scale(0.8);}
      }

    </style>

  </head>

  <body>

    <!-- Page Content -->
    <div class="container center-absolute">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h1 id="title">Nothing Playing</h1>
          <p class="lead" id="artist"></p>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-10 col-lg-offset-1">
          <div class="row justify-content-center">
          <div class="col-3">
            <h2><i class="fa fa-2x fa-backward push"></i></h2>
          </div>
          <div class="col-3">
            <h2><i class="fa fa-2x fa-pause push" id="play-pause-toggle"></i></h2>
          </div>
          <div class="col-3">
            <h2><i class="fa fa-2x fa-forward push"></i></h2>
          </div>
          </div>
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
      var stauts = "paused";

      setInterval(triggerSongUpdate, 1000);

      // Force update before interval
      jQuery(".fa.push").on("click", function() {
        triggerSongUpdate();
        $(this).toggleClass("pushed");
        var button = $(this);
        setTimeout(function(){
          button.toggleClass("pushed");
        }, 500)
      });

      // Previous Track
      jQuery(".fa-backward").on("click", function() {
        $.getJSON('media.php?command=prevTrack', function(data) {
          console.log(data);
        });
      });

      // Next track
      jQuery(".fa-forward").on("click", function() {
        $.getJSON('media.php?command=nextTrack', function(data) {
          console.log(data);
        });
      });

      // Pause song
      jQuery("#play-pause-toggle").on("click", function() {
        if(status == "Playing") {
            $(this).removeClass("fa-pause").addClass("fa-play");
            $.getJSON('media.php?command=pause', function(data) {
                console.log(data);
            });
        } else if(status == "Paused") {
            $(this).removeClass("fa-play").addClass("fa-pause");
            $.getJSON('media.php?command=play', function(data) {
                console.log(data);
            });
        }
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
            
            // Check & set local link if it exists first
            if("Album_Artwork" in mediaObject) {
                $("body").css("background-image", "url("+mediaObject["Album_Artwork"]+")");
            } else {
                getAlbumArtwork(mediaObject["Album"], mediaObject["Artist"]);
            }
        }

        if("playing" in mediaObject) { status = "Playing"; jQuery("#play-pause-toggle").removeClass("fa-play").addClass("fa-pause"); }
        else if("paused" in mediaObject) { status = "Paused"; jQuery("#play-pause-toggle").removeClass("fa-pause").addClass("fa-play"); }

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
                key: "AIzaSyBkLyJ_C764-xzcMNomj5YUOI-jqzCoVgo",
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
