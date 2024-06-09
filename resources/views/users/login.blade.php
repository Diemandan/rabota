<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.83.1">
    <title>Signin page</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

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
    <link href="../css/signin.css" rel="stylesheet">
    <script src="//upsales.pro/api/w/1/widget.js" async></script>
</head>
<body class="text-center">

<main class="form-signin">
    @if($errors->has('email'))
        <div class="alert alert-danger" role="alert">
            {{ $errors->first('email') }}
        </div>
    @endif

    <form action="{{route('user.login')}}" method="POST">
        @csrf
        <img class="mb-4" src="../img/logo.png" alt="" width="72" height="57">
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

        <div class="form-floating">
            <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com" required>
            <label for="floatingInput">Email address</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required>
            <label for="floatingPassword">Password</label>
        </div>

        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" name="remember" value="1"> Remember me
            </label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>
    </form>

        <div>
            <script
                class="amocrm_oauth"
                charset="utf-8"
                data-name="Final integration"
                data-description="Integration description"
                data-redirect_uri="https://zp-tir.of.by/login"
                data-secrets_uri="https://zp-tir.of.by/amo"
                data-logo=""
                data-scopes="crm,notifications"
                data-title="Button"
                data-compact="false"
                data-class-name="className"
                data-color="default"
                data-state="state"
                data-error-callback="functionName"
                data-mode="popup"
                src="https://www.amocrm.ru/auth/button.min.js"
            ></script>
        </div>
</main>



</body>
</html>
