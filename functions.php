<?php

require_once('includes/dotstarter.php');

new DOT_Starter();


function format_french_date($date_string)
{
    $timestamp = strtotime($date_string);
    $days = array('Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.');
    $months = array('', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');

    return $days[date('w', $timestamp)] . ' ' . date('d', $timestamp) . ' ' . $months[date('n', $timestamp)];
}
