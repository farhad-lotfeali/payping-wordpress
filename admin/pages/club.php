<?php

function pp_admin_club()
{
    if (isset($_GET['ac'])) {
        $action = $_GET['ac'];
    } else {
        $action = '';
    }
    switch ($action) {
        case 'activate':
            pp_club_activate();
            break;
        case 'deactivate':
            pp_club_deactivate();
            break;
        default:
            pp_club();
    }
}

function pp_club()
{
    require "club.html.php";
}

function pp_club_activate()
{
    $api = new pp_Api();
    $club = $api->add_bonus();

    if ($club->code >= 200 && $club->code < 300) {
        add_action('admin_notices_pp', function () use ($club) {
            printf('<div class="notice notice-success"><p>%1$s</p></div>', $club->body);
        });
    } else {
        add_action('admin_notices_pp', function () use ($club) {
            printf('<div class="notice notice-error"><p>%1$s</p></div>', $club->body);
        });
    }
    pp_club();
}

function pp_club_deactivate()
{
    $api = new pp_Api();
    $club = $api->remove_bonus();

    if ($club->code >= 200 && $club->code < 300) {
        add_action('admin_notices_pp', function () use ($club) {
            printf('<div class="notice notice-success"><p>%1$s</p></div>', $club->body);
        });
    } else {
        add_action('admin_notices_pp', function () use ($club) {
            printf('<div class="notice notice-error"><p>%1$s</p></div>', $club->body);
        });
    }
    pp_club();
}
