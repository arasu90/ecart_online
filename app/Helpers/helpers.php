<?php 

use App\Models\Website;

if (!function_exists('getLogo')) {
    function getLogo() {
        $site_data = Website::first();
        return $site_data ? $site_data->site_logo : '/storage/website/noimage.png';
    }
}

if (!function_exists('getSiteDesc')) {
    function getSiteDesc() {
        $site_data = Website::first();
        return $site_data ? $site_data->site_desc : '';
    }
}

if (!function_exists('getSiteAddress')) {
    function getSiteAddress() {
        $site_data = Website::first();
        return $site_data ? $site_data->site_address : '';
    }
}

if (!function_exists('getSiteEmail')) {
    function getSiteEmail() {
        $site_data = Website::first();
        return $site_data ? $site_data->site_email : '';
    }
}

if (!function_exists('getSiteMobileNo')) {
    function getSiteMobileNo() {
        $site_data = Website::first();
        return $site_data ? $site_data->site_mobile : '';
    }
}

if (!function_exists('getGpayImg')) {
    function getGpayImg() {
        $site_data = Website::first();
        return $site_data ? $site_data->site_gpay_img : '/storage/website/noimage.png';
    }
}