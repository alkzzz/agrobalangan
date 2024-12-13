<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /*! Other styles */
        /* Custom error page styling */
        .error-container {
            text-align: center;
            padding: 60px;
        }

        .error-code {
            font-size: 150px;
            font-weight: bold;
        }

        .error-message {
            font-size: 22px;
        }

        .btn-back-home {
            margin-top: 25px;
        }
    </style>
</head>

<body class="antialiased bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6">
                <div class="error-container">
                    <div class="error-code">@yield('code')</div>
                    <div class="error-message">@yield('message')</div>
                    <a href="/" class="btn btn-primary btn-back-home">Back to Home</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>
