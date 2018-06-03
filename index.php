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
          <h1 class="mt-5">A Bootstrap 4 Starter Template</h1>
          <p class="lead">Complete with pre-defined file paths and responsive navigation!</p>
          <ul class="list-unstyled">
            <li>Bootstrap 4.1.1</li>
            <li>jQuery 3.3.1</li>
          </ul>
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
      jQuery("#testBtn").on("click", function() {
        $.getJSON('media.php', function(data) {
          updateSongInfo(data);
        });
      });
      function updateSongInfo(mediaObject) {
        console.log(mediaObject);
      }
    </script>

  </body>

</html>
