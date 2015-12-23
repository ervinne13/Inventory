<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//
/* * ************************************************************************* */
// <editor-fold defaultstate="collapsed" desc="skarla">

function skarla_url($url) {
    return url("skarla/{$url}");
}

function skarla_js_url($url) {
    return url("skarla/assets/js/{$url}");
}

function skarla_css_url($url) {
    return url("skarla/assets/css/{$url}");
}

function skarla_images_url($url) {
    return url("skarla/assets/images/{$url}");
}

function skarla_vendor_url($url) {
    return url("skarla/assets/vendor/{$url}");
}

function skarla_bower_url($url) {
    return url("skarla/assets/bower_components/{$url}");
}


// </editor-fold>

/* * ************************************************************************* */
// <editor-fold defaultstate="collapsed" desc="Vendor">

function vendor_url($url) {
    return url("vendor/{$url}");
}

function vendor_js_url($url) {
    return url("vendor/js/{$url}");
}

function vendor_css_url($url) {
    return url("vendor/css/{$url}");
}

function vendor_fonts_url($url) {
    return url("vendor/fonts/{$url}");
}

// </editor-fold>


/* * ************************************************************************* */
// <editor-fold defaultstate="collapsed" desc="Data Tables">

function datatables_bs_url($url) {
    return url("bower_components/datatables.net-bs/{$url}");
}

function datatables_url($url) {
    return url("bower_components/datatables.net/{$url}");
}

// </editor-fold>