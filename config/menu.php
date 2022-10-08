<?php

return [
    'primary-admin' => [
        [
            'title' => 'گزارشات',
            'url' => '/dashboard',
            'permission' => 'dashboard'
        ],
        [
            'title' => 'تشکیل پرونده',
            'url' => '/dashboard/plans/create',
            'permission' => 'create-plan'
        ],
        [
            'title' => 'ایمپورت اکسل',
            'url' => '',
            'permission' => 'import',
            'children' => [
                [
                    'title' => 'ایمپورت طرح ها',
                    'url' => '/dashboard/import/plans',
                    'permission' => 'import-plans'
                ],
                [
                    'title' => 'ایمپورت آدرس ها',
                    'url' => '/dashboard/import/addresses',
                    'permission' => 'import-addresses'
                ],
                [
                    'title' => 'ایمپورت محله ها',
                    'url' => '/dashboard/import/areas',
                    'permission' => 'import-areas'
                ],
            ]
        ],
        [
            'title' => 'لیست طرح ها',
            'url' => '/dashboard/plans',
            'permission' => 'plans'
        ],
        [
            'title' => 'بازدید های انجام شده',
            'url' => '/dashboard/observes/done',
            'permission' => 'done-observes'
        ],
        [
            'title' => 'اطلاعات پایه',
            'url' => '',
            'permissions' => 'options',
            'children' => [
                [
                    'title' => 'مدارک',
                    'url' => '/dashboard/documents',
                    'permissions' => 'documents'
                ],
                [
                    'title' => 'ادارات',
                    'url' => '/dashboard/organizations',
                    'permissions' => 'organizations'
                ],
                [
                    'title' => 'ناظران',
                    'url' => '/dashboard/supervisors',
                    'permissions' => 'supervisors'
                ],
                [
                    'title' => 'دوره ها',
                    'url' => '/dashboard/courses',
                    'permissions' => 'courses'
                ],
                [
                    'title' => 'دوره های پیشنهاد شده',
                    'url' => '/dashboard/suggests',
                    'permissions' => 'suggests'
                ],
            ]
        ],
        [
            'title' => 'پروفایل',
            'url' => '/dashboard/profile',
            'permission' => 'profile'
        ],
        [
            'title' => 'خروج',
            'url' => '/dashboard/logout',
            'permission' => 'logout'
        ]
    ],
    'primary-supervisor' => [
        [
            'title' => 'گزارشات',
            'url' => '/dashboard',
            'permission' => 'dashboard'
        ],
        [
            'title' => 'لیست طرح ها',
            'url' => '/dashboard/plans',
            'permission' => 'plans'
        ],
        [
            'title' => 'بازدید های انجام شده',
            'url' => '/dashboard/observes/done',
            'permission' => 'done-observes'
        ],
        [
            'title' => 'پروفایل',
            'url' => '/dashboard/profile',
            'permission' => 'profile'
        ],
        [
            'title' => 'خروج',
            'url' => '/dashboard/logout',
            'permission' => 'logout'
        ]
    ],
    'quick' => [
        [
            'title' => 'افزودن مجری',
            'url' => '/',
            'icon' => 'flaticon2-drop'
        ],
        [
            'title' => 'افزودن کسب و کار',
            'url' => '/',
            'icon' => 'flaticon2-list-3',
            'separator' => true,
        ],
        [
            'title' => 'همه بازدید ها',
            'url' => '/',
            'icon' => 'flaticon2-rocket-1',
            'separator' => true,
        ],
        [
            'title' => 'گزارش فرم ۱۲ و ۱۳',
            'url' => '/dashboard/report/13',
            'icon' => 'flaticon2-bell-2'
        ],
        [
            'title' => 'گزارش استانی',
            'url' => '/',
            'icon' => 'flaticon2-bell-2'
        ],
        [
            'title' => 'گزارش شهری',
            'url' => '/',
            'icon' => 'flaticon2-gear'
        ],
        [
            'title' => 'گزارش منطقه ای',
            'url' => '/',
            'icon' => 'flaticon2-magnifier-tool'
        ],
        [
            'title' => 'گزارش اداری',
            'url' => '/',
            'icon' => 'flaticon2-bell-2'
        ],
    ],
    'footer' => [
        [
            'title' => 'درباره ما',
            'url' => 'https://daneshjooyar.info/about',
        ],
        [
            'title' => 'تیم توسعه',
            'url' => 'https://daneshjooyar.info/team/emdad',
        ],
        [
            'title' => 'تماس با ما',
            'url' => 'https://daneshjooyar.info/contact',
        ],
    ],
];
