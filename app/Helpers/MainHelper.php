<?php

if (!function_exists('navigation_links')) {
    function navigation_links()
    {
        $role = session('user_role'); // ex: 'super-admin', 'user', 'staff', dll
        $permissions = session('user_permissions', []); // ex: ['user.view', 'role.view', 'permission.view']

        $links = [
            [
                'href' => 'dashboard',
                'text' => 'Dashboard',
                'is_multi' => false,
                'section_icon' => 'bi bi-grid',
                'permission' => null, // semua boleh lihat
            ],
        ];

        // Menu untuk super admin
        if (in_array('user.view', $permissions)) {
            $links[] = [
                'href' => [
                    [
                        'section_text' => 'User Management',
                        'section_list' => [
                            [
                                'href' => 'admins.list',
                                'text' => 'User',
                                'icon' => 'bi bi-person',
                                'permission' => 'user.view',
                            ],
                            [
                                'href' => 'list.roles',
                                'text' => 'Role',
                                'icon' => 'bi bi-people',
                                'permission' => 'user.view',
                            ],
                            [
                                'href' => 'list.permissions',
                                'text' => 'Permission',
                                'icon' => 'bi bi-shield-lock',
                                'permission' => 'user.view',
                            ],
                        ],
                        'section_icon' => 'bi bi-person-gear',
                    ],
                ],
                'text' => 'User Management',
                'is_multi' => true,
            ];
        }

        // Menu untuk role user biasa
        if (in_array('user.create', $permissions)) {
            $links[] = [
                'href' => [
                    [
                        'section_text' => 'User',
                        'section_list' => [
                            [
                                'href' => 'test',
                                'text' => 'Profil Saya',
                                'icon' => 'bi bi-person-circle',
                                'permission' => 'user.view',
                            ],
                        ],
                        'section_icon' => 'bi bi-person-circle',
                    ],
                ],
                'text' => 'User Menu',
                'is_multi' => true,
            ];
        }

        // Filter menu berdasarkan permission dari session
        $filtered = [];
        foreach ($links as $link) {
            if (!$link['is_multi']) {
                if (!$link['permission'] || in_array($link['permission'], $permissions)) {
                    $filtered[] = $link;
                }
            } else {
                $sections = [];
                foreach ($link['href'] as $section) {
                    $sectionList = array_filter($section['section_list'], function ($item) use ($permissions) {
                        return !$item['permission'] || in_array($item['permission'], $permissions);
                    });

                    if (!empty($sectionList)) {
                        $section['section_list'] = $sectionList;
                        $sections[] = $section;
                    }
                }

                if (!empty($sections)) {
                    $link['href'] = $sections;
                    $filtered[] = $link;
                }
            }
        }

        return $filtered;
    }
}

if (!function_exists('array_to_object')) {
    function array_to_object($array)
    {
        return json_decode(json_encode($array));
    }
}
