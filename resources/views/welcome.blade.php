<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" href="{{ asset('image/loginlogo.png') }}" />
        <title>GS.RADEEL</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }
            .links{
                bottom: 144px;
                position: absolute;
                background-color: #70c5f9;
                left: 62px;
                cursor: pointer;
                padding: 10px;
                border-radius: 19px;
            }
            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
        .img-thumbnail{
            width: 55%;
            height: 90%;
            right: 0;
            bottom: 73px;
            position: absolute;
            z-index: 1;
        }
        .title{
            margin-bottom:0 ;
            margin-left: 33px;
            position: relative;
            z-index: 2;
        }
        .parg{
            margin-left: 34px;
            font-size: 23px;
        }
        .container{
            width: 40%;
            position: relative;
            z-index: 3;
        }
        .logo{
            width: 33px;
            margin: 11px;
        }
        .col-md-4.tag {
    margin-left: 29px;
}
            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div >
            <div class="top-left">
                <img src="{{ asset('image/logo.jpg') }}"  class="logo" alt="logo">
                <h2 class="radeel" style="position: absolute;
                top: -5px;
                left: 52px;">GS.RADEEL</h2>
            </div>
            @if (Route::has('login'))
            <div class="row">
              
            
                <div class="col-md-4 links">

                    @auth
                        <a href="{{ url('/dashboard') }}">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                       <!--  @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif-->
                    @endauth
                </div>
                </div>
            @endif
            <div class="row">

            <div class="col-md-4 tag">
               <h3 class="title">Bienvenue</h3> 
               <div class="container">
               <p class="parg">Accélérer et faciliter la gestion des articles et la gestion des demandes et grée des articles retournés et fournis</p>
            </div>
            </div>
                    <div class="col-md-4">
                        <img class="img-thumbnail"  src="{{ asset('image/welcomeImage.png') }}" alt="welcome">
                    </div>

            </div>
        </div>
       
    </body>
</html>
