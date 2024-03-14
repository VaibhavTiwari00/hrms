<!-- Favicon -->
<link rel="shortcut icon" type="image/x-icon" href="<?= get_assets() ?>img/favicon.png">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="<?= get_assets() ?>css/bootstrap.min.css">

<!-- Fontawesome CSS -->
<link rel="stylesheet" href="<?= get_assets() ?>css/font-awesome.min.css">

<!-- Lineawesome CSS -->
<link rel="stylesheet" href="<?= get_assets() ?>css/line-awesome.min.css">

<!-- Main CSS -->
<link rel="stylesheet" href="<?= get_assets() ?>css/style.css">


<style>
    .container_timer {
        align-items: center;
        display: flex;
        justify-content: center;
        flex-direction: column;
        height: 100%;
        width: 100%;
    }

    .clock {
        display: flex;
    }

    .clock div {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 100px;
        height: 100px;
        margin: 10px;
        padding: 10px;

        background: white;
        box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.4);
        border-radius: 10px;
        cursor: pointer;
    }

    .clock div span {
        font-size: 40px;
        font-weight: 700;
    }

    .title_timer {
        font-size: xx-large;
        margin-bottom: 20px;
    }

    @media (max-width: 500px) {
        .title_timer {
            font-size: x-large;
        }

        .clock div {
            width: 70px;
            height: 70x;
            margin: 5px;
            padding: 5px;
        }

        .clock div span {
            font-size: 25px;
            font-weight: 700;
        }
    }
</style>