<?php

if (!function_exists('navigation_links')) {

    function navigation_links()
    {
        return [
            [
                'href' => 'dashboard',
                'text' => 'Dashboard',
                'is_multi' => false,
                'section_icon' => 'bi bi-grid-fill',
            ],
            [
                'href' => [
                    [
                        'section_text' => 'Admin',
                        'section_list' => [
                            ['href' => 'admins.list', 'text' => 'List Admin'],
                            ['href' => 'admins.create', 'text' => 'Create Admin'],
                        ],
                        'section_icon' => 'bi bi-person-fill',
                    ],
                ],
                'text' => 'Admin',
                'is_multi' => true,
            ],
        ];
    }
}

if (!function_exists('array_to_object')) {

    function array_to_object($array)
    {
        return json_decode(json_encode($array));
    }
}
