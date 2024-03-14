<?php

function base_url()
{
    return DOMAIN;
}

function home_path()
{
    return DOMAIN;
}

function get_assets()
{
    return DOMAIN . '/assets/';
}

function get_css($file_name = "")
{
    return DOMAIN . '/assets/css/' . $file_name;
}

function get_img($file_name = "")
{
    return DOMAIN . '/assets/img/' . $file_name;
}

function get_js($file_name = "")
{
    return DOMAIN . '/assets/js/' . $file_name;
}


function get_file($file_name)
{
    if ($file_name != '') {

        $brack_file_name = explode('.', $file_name);
        $extension = $brack_file_name[(count($brack_file_name) - 1)];
        $response_link = "";
        switch ($extension) {
            case 'css':
                $response_link = get_css() . $file_name;
                break;
            case 'js':
                $response_link = get_js() . $file_name;
                break;

            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
                $response_link = get_img() . $file_name;
                break;
        }
        return $response_link;
    }
}
