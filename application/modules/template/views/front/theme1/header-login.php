<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="description" content="">
<meta name="keywords" content="app, responsive, jquery, bootstrap, dashboard, admin">
<title>QA242 - Login</title>
<script src="<?php echo STATIC_FRONT_JS?>jquery-2.1.3.min.js"></script>
  <script src="<?php echo STATIC_ADMIN_JS ?>jquery-ui.min.js" ></script>
  <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS ?>bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>toastr.css" type="text/css">
  <script src="<?php echo STATIC_ADMIN_JS?>toastr.js"></script>
<style type="text/css">
  .body{
      transition: all .5s;
      padding: 1px;
    }
body {
    -moz-transform: scale(0.8, 0.8); /* Moz-browsers */
    zoom: 0.8; /* Other non-webkit browsers */
    zoom: 80%; /* Webkit browsers */
}
    .veen{
      width: 70%;
      margin: 70px auto;
          background: #7BABED;
      height: 400px;
      display:table;
      position: relative;
      box-shadow: 0 0 4px rgba(0,0,0,.14), 0 4px 8px rgba(0,0,0,.28);
    }
    .veen > div {
      display: table-cell;
      vertical-align: middle;
      text-align: center;
      color: #fff;
    }
    .veen button{
      background: transparent;
      //background-image: linear-gradient(90deg, #e0b722, #ff4931);
      display: inline-block;
      padding: 10px 30px;
      border: 3px solid #fff;
      border-radius: 50px;
      background-clip: padding-box;
      position: relative;
      color: #FFF;
      //box-shadow: 0 0 4px rgba(0,0,0,.14), 0 4px 8px rgba(0,0,0,.28);
      transition: all .25s;
    }
    .veen button.dark{
      border-color: #7BABED;
      background: #7BABED;
    }
    .veen .move button.dark{
      border-color: #e0b722;
      background: #e0b722;
    }
    .veen .splits p{
      font-size: 18px;
    }
    .veen button:active{
      box-shadow: none;     
    }
    .veen button:focus{
      outline: none;      
    }
    .veen > .wrapper {
      position: absolute;
      width: 40%;
      height: 120%;
      top: -10%;
      left: 50%;
      background: #fff;
      box-shadow: 0 0 4px rgba(0,0,0,.14), 0 4px 8px rgba(0,0,0,.28);
      transition: all .5s;
      color: #303030;
      overflow: hidden;
    }
    .veen .wrapper > form{
      padding: 15px 30px 30px;
      width: 100%;
      transition: all .5s;
      background: #fff;
      width: 83%; 
    }
.veen .wrapper > form:focus{
  outline: none;
}
    .veen .wrapper #login{
      padding-top: 20%;
      visibility: visible;
    }
    .veen .wrapper #register{
      transform: translateY(-80%) translateX(100%);
      visibility: hidden;
    }
    .veen .wrapper.move #register{
      transform: translateY(-80%) translateX(0%);
      visibility: visible;
    }
    .veen .wrapper.move #login{
      transform: translateX(-100%);
      visibility: hidden;
    }
    .veen .wrapper > form > div {
      position: relative;
      margin-bottom: 15px;
    }
    .veen .wrapper label{
      position: absolute;
      top: -7px;
      font-size: 12px;
      white-space: nowrap;
      background: #fff;
      text-align: left;
      left: 15px;
      padding: 0 5px;
      color: #999;
      pointer-events: none;
    }
    .veen .wrapper h3{
      margin-bottom: 25px;
    }
    .veen .wrapper input{
      height: 40px;
      padding: 5px 15px;
      width: 100%;
      border: solid 1px #999;
    }
.veen .wrapper input{
      height: 40px
      padding: 5px 15px;
      width: 100%;
      border: solid 1px #999;
    }
    .veen .wrapper input:focus{
      outline: none;
      border-color: #ff4931;
    }
    .veen > .wrapper.move{
      left: 45%;
    }
    .veen > .wrapper.move input:focus{
      border-color: #e0b722;
    }
    @media (max-width: 767px){
      .veen{
        padding: 5px;
        margin: 0;
        width: 100%;
        display: block;
      }
      .veen > .wrapper{
        position: relative;
        height: auto;
        top: 0;
        left: 50%;
        width: 100%;
      }
      .veen > div{
        display: inline-block;
      }
      .splits{
        width: 50%;
        background: #fff;
        float: left;
      }
      .splits button{
        width: 100%;
        border-radius: 0;
        background: #505050; 
        border: 0;
        opacity: .7;
      }
      .splits button.active{
        opacity: 1;
      }
      .splits button.active{
        opacity: 1;
        background: #ff4931;
      }
      .splits.rgstr-btn button.active{
        background: #e0b722;
      }
      .splits p{
        display: none;
      }
      .veen > .wrapper.move{
        left: 50%;
      }
    }

input:-webkit-autofill, textarea:-webkit-autofill, select:-webkit-autofill{
  box-shadow: inset 0 0 0 50px #fff
}
</style>


<?php
  $message = $this->session->flashdata('message');
  $status = $this->session->flashdata('status');
  if (isset($message) && !empty($message) && $status == 'success') {?>
    <script>$(document).ready(function() {toastr.success("<?php echo $message?>")});</script>
  <?php }
  if (isset($message) && !empty($message) && $status == 'error') {?>
    <script>$(document).ready(function() {toastr.error("<?php echo $message?>")});</script>
  <?php }
?>
</head>
<body>

<div class="body">