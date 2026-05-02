<?php

namespace App\Support;

class AdminMenu
{
    public static function permissions(): array
    {
        return [
            [
                'name' => 'Dashboard',
                'permission' => 'menu.dashboard',
                'route' => 'dashboard',
                'icon' => 'ti ti-layout-dashboard',
            ],
            [
                'name' => 'Master Data',
                'permission' => 'menu.master-data',
                'icon' => 'ti ti-basket',
                'children' => [
                    ['name' => 'Pasien', 'permission' => 'menu.patients', 'route' => 'patients.index'],
                    ['name' => 'Pegawai', 'permission' => 'menu.employees', 'route' => 'employees.index'],
                    ['name' => 'Treatments', 'permission' => 'menu.treatments', 'route' => 'treatments.index'],
                    ['name' => 'Bank', 'permission' => 'menu.bank', 'route' => 'bank.index'],
                    ['name' => 'Testimoni', 'permission' => 'menu.testimoni', 'route' => 'testimoni.index'],
                ],
            ],
            [
                'name' => 'Rekam Medis',
                'permission' => 'menu.medical-records',
                'route' => 'medical-records.index',
                'icon' => 'ti ti-file-description',
            ],
            [
                'name' => 'Penggajian',
                'permission' => 'menu.payrolls',
                'route' => 'payrolls.index',
                'icon' => 'ti ti-report-money',
            ],
            [
                'name' => 'Pengaturan',
                'permission' => 'menu.roles-permissions',
                'icon' => 'ti ti-shield-lock',
                'children' => [
                    ['name' => 'Role', 'permission' => 'menu.roles', 'route' => 'admin.roles.index'],
                    ['name' => 'Hak Akses', 'permission' => 'menu.permissions', 'route' => 'admin.permissions.index'],
                ],
            ],
        ];
    }

    public static function permissionNames(): array
    {
        $names = [];

        foreach (self::permissions() as $menu) {
            $names[] = $menu['permission'];

            foreach ($menu['children'] ?? [] as $child) {
                $names[] = $child['permission'];
            }
        }

        return $names;
    }
}
