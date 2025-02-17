<html>
    <head>
        <title>
            @yield('title')
        </title>

        <link rel="stylesheet" href="assets/vendors/themify-icons/css/themify-icons.css">

        <link rel="stylesheet" href="assets/css/meyawo.css">
    </head>
    <body>
    <nav class="navbar navbar-expand-sm navbar-light bg-light rounded shadow mb-3">
        <div class="container">
            <a class="navbar-brand" href="{{route('dashboard')}}">Bureau of Records</a>
            <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('dashboard')}}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('reports')}}">Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('settings')}}">Settings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('logout')}}">Logout</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
        @yield('content')

        <script src="assets/vendors/jquery/jquery-3.4.1.js"></script>
        <script src="assets/vendors/bootstrap/bootstrap.bundle.js"></script>


        <script src="assets/vendors/bootstrap/bootstrap.affix.js"></script>


        <script src="assets/js/meyawo.js"></script>
    </body>
</html>
