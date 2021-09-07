<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link href="{{ asset(mix('/css/app.css')) }}" rel="stylesheet">
    <link href="{{ asset(mix('/css/all.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/vue-select.css') }}" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</head>

<body class="sidebar-icon-only">
    @inertia
</body>

<script src="{{ asset(mix('/js/manifest.js')) }}"></script>
<script src="{{ asset(mix('/js/vendor.js')) }}"></script>
<script src="{{ asset(mix('/js/app.js')) }}"></script>
<!-- <script src="{{ asset(mix('/js/misc.js')) }}"></script> -->
<script src="{{ asset(mix('/js/hoverable-collapse.js')) }}"></script>
</html>