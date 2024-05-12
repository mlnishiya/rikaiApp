<!doctype html>
<html lang="en" class="h-100">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Nishiya's Tool KIT">
        <title>Nishiya Tools</title>
        <!-- Bootstrap core CSS -->
        <link href="bootstrap.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
            }

            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }
        </style>


        <!-- Custom styles for this template -->
        <link href="cover.css" rel="stylesheet">
        <style>
            .nav-masthead .nav-link:hover,
            .nav-masthead .nav-link:focus {
                border-bottom-color: rgba(255, 255, 255, .25);
            }

            .nav-masthead .nav-link + .nav-link {
                margin-left: 1rem;
            }

            .nav-masthead .active {
                color: #fff;
                border-bottom-color: #ff7302;
            }
        </style>
    </head>
    <body class="d-flex h-100 text-center text-white bg-dark">

        <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
            <header class="mb-auto">
                <div>
                    <h3 class="float-md-start mb-0">nishi<span style="color:#ff7302">ya</span></h3><small style='float: right'>RikaiAPP</small>
                </div>
            </header>

            <main class="px-3">
                <form id="formulario" method="post" enctype="multipart/form-data">
                    <input type="file" id="arquivo" name="arquivo" accept="image/*;capture=camera" onchange="submitHandler()" style='display: none'>
                    <br><br>
                </form>

                <img class='cam' src="cam.png" onclick='$("#arquivo").click()'/>
                <img class='loading' src="loading.gif" style='display: none'/>
                <div id="resposta">

                </div>




            </main>

            <footer class="mt-auto text-white-50">
                <p><?= date("Y")?> nishiya copyright</p>
            </footer>
        </div>



        <script>

            function submitHandler() {
                if ($("#arquivo").val()) {
                    var formData = new FormData($('#formulario')[0]);
                    $.ajax({
                        url: "upload.php",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: function () {
                            $(".loading").show('slow');
                            $("#resposta").html("");
                            $(".cam").appendTo("body");
                            $(".cam").css("position", "absolute");
                            $(".cam").css("margin-top", "5px");
                            $(".cam").css("float", "right");
                        },
                        success: function (data) {
                            $(".loading").hide();
                            $("#resposta").html(data);
                        }
                    });
                }
            }
        </script>

    </body>
</html>
