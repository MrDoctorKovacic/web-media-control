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
        background-size: cover;
        background-position: center center;
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
        <div class="col-lg-12 text-center">
          <h1 class="mt-5" id="title">A Bootstrap 4 Starter Template</h1>
          <p class="lead" id="artist">Complete with pre-defined file paths and responsive navigation!</p>
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
      // Get song info
      jQuery("#testBtn").on("click", function() {
        $.getJSON('media.php', function(data) {
          updateSongInfo(data);
        });
      });

      // Update UI with media object info
      function updateSongInfo(mediaObject) {
        console.log(mediaObject);
        getAlbumArtwork(mediaObject["Title"], mediaObject["Artist"]);
        jQuery("#title").text(mediaObject["Title"]);
        jQuery("#artist").text(mediaObject["Artist"]);
      }

      // Update album artwork. Adapted from aybalasubramanian's fiddle 
      // http://jsfiddle.net/aybalasubramanian/zpdseds7/
      function getAlbumArtwork(title, artist) {
        var searchQuery = title+" "+artist+" album cover";
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
            $.each(googleResults, function(i, o) {
              $.ajax({
                url  : o.link,
                type : 'post'
              }).done(function(data, statusText, xhr){
                if(xhr.status == 200) {
                  console.log(data.items[0].link);
                  $("body").css("background-image", "url("+data.items[0].link+")");
                  return;
                }
              });
            });
        });
    }
    </script>

  </body>

</html>
