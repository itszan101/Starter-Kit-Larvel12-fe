<?php

if (!function_exists('navigation_links')) {

    function navigation_links()
    {
        $role = session('user_role'); // ambil dari sesi
        $links = [
            [
                'href' => 'dashboard',
                'text' => 'Dashboard',
                'is_multi' => false,
                'section_icon' => 'bi bi-grid-fill',
            ],
        ];

        if ($role === 'admin') {
            $links[] = [
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
            ];
        }

        if ($role === 'user') {
            $links[] = [
                'href' => [
                    [
                        'section_text' => 'User',
                        'section_list' => [
                            ['href' => 'test', 'text' => 'Profil Saya'],
                        ],
                        'section_icon' => 'bi bi-person-circle',
                    ],
                ],
                'text' => 'User Menu',
                'is_multi' => true,
            ];
        }

        return $links;
    }
}

if (!function_exists('array_to_object')) {

    function array_to_object($array)
    {
        return json_decode(json_encode($array));
    }
}
