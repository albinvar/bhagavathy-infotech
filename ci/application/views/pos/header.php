<!DOCTYPE html>
<html lang="en">
<head>

        <meta charset="utf-8" />
        <title>Artcl Finance Management System</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content>
        <meta name="author" content>

        <link href="<?= base_url() ?>components/posassets/css/vendor.min.css" rel="stylesheet">
        <link href="<?= base_url() ?>components/posassets/css/app.min.css" rel="stylesheet">
        <!-- Head js -->

        <?php
        $todaydate = date('Y-m-d');
        if(($todaydate >= $this->finstartdate) && ($todaydate <= $this->finenddate))
        {
            
        }else{
            ?>
            <style type="text/css">
                .finyearaddbutton{
                    display: none;
                }
            </style>
            <?php
        }
        ?>

    </head>
    <body class="pace-top">

    <div id="app" class="app app-content-full-height app-without-sidebar app-without-header">

    <div id="content" class="app-content p-1 ps-xl-4 pe-xl-4 pt-xl-3 pb-xl-3">

    <div class="pos card" id="pos">
    <div class="pos-container card-body">

    <div class="pos-menu">

    <div class="logo">
        <a href="<?= base_url() ?>business/dashboard">
        <div class="logo-img"><img src="<?= base_url() ?>components/images/artcllogo.png" alt="" height="55"></div>
        <!--<div class="logo-text">Artcl</div>-->
        </a>
    </div>