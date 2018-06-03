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
        jQuery("#title").text(mediaObject["Title"]);
        jQuery("#artist").text(mediaObject["Artist"]);
      }

      // Update album artwork. Adapted from aybalasubramanian's fiddle 
      // http://jsfiddle.net/aybalasubramanian/zpdseds7/
      function getAlbumArtwork(title, artist) {
        var searchQuery = title+" "+artist+" album cover";

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
            }
        }).done(function(data) {
            console.log(data);
            var googleResults = data.items;
            console.log(data.items[0].image.thumbnailLink);
        });
/*
        function make_base_auth(user, password) {
            var tok = user + ':' + password;
            var hash = btoa(tok);
            return "Basic " + hash;
        }
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "https://api.datamarket.azure.com/Bing/Search/v1/Image",
            beforeSend: function(xhr) {
                xhr.setRequestHeader("Authorization", make_base_auth("", "GfsqxTjDPIKNuXQZDeqj2z4uaaHNx9X0QhKYBn4Xgeg="));
            },
            data: {
                Query: "'" + searchQuery + "'",
            }
        }).done(function(data) {
            //alert("Success");
            console.log(data);
            var bingResults = data.d.results;
            $(".result li").remove();
            //$('#result').isotope('destroy');
            $.each(bingResults, function(i, o) {
                var imageURL = o.Thumbnail.MediaUrl;
                if (i % 2 != 0) {
                    $("#result").append("<div class='result_item'><img src='" + imageURL + "' /></div>");
                } else {
                    $("#result").append("<div class='result_item'><img src='" + imageURL + "' /></div>");
                }
            })
        });*/
    }
    </script>

  </body>

</html>
