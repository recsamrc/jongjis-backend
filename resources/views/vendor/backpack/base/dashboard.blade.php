@extends('custom.base.layouts.dashboard')

@php
    Widget::add([
        'name'        => 'show_total_users',
        'type'        => 'progress',
        'class'       => 'card text-white bg-primary mb-2',
        'value'       => '11.456',
        'description' => 'Registered users.',
        'wrapper' => [
            'class' => 'col-sm-6 col-md-4 col-lg-3',
        ],
    ]);
    Widget::add([
        'name'        => 'show_total_rentals',
        'type'        => 'progress',
        'class'       => 'card text-white bg-success mb-2',
        'value'       => '11.456',
        'description' => 'Total rentals.',
        'wrapper' => [
            'class' => 'col-sm-6 col-md-4 col-lg-3',
        ],
    ]);
    Widget::add([
        'name'        => 'show_total_bikes',
        'type'        => 'progress',
        'class'       => 'card text-white bg-info mb-2',
        'value'       => '11.456',
        'description' => 'Total bikes.',
        'wrapper' => [
            'class' => 'col-sm-6 col-md-4 col-lg-3',
        ],
    ]);
    Widget::add([
        'name'        => 'show_total_shops',
        'type'        => 'progress',
        'class'       => 'card text-white bg-warning mb-2',
        'value'       => '11.456',
        'description' => 'Total shops.',
        'wrapper' => [
            'class' => 'col-sm-6 col-md-4 col-lg-3',
        ],
    ]);
@endphp