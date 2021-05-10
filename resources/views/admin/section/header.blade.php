<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Joycosmetics') }}</title>
  <!-- Favicon -->
  <link rel="icon" href="{{asset('img/core-img/logo.png')}}" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Lora|Material+Icons" rel="stylesheet">
  <!-- Icons -->
  <link rel="stylesheet" href=" {{ asset('css/admin/assets/vendor/nucleo/css/nucleo.css') }} " type="text/css">
  <link rel="stylesheet"  type="text/css" href=" {{ asset('css/admin/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }} ">
  <!-- Page plugins -->
  <!-- Argon CSS -->
  <link rel="stylesheet" href=" {{ asset('css/admin/assets/css/argon.css?v=1.2.0') }} " type="text/css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
  <!-- <link rel="stylesheet"  type="text/css" href="{{ asset('css/admin/assets/datatables.net-bs/css/dataTables.bootstrap4.css') }}"> -->

<body>
