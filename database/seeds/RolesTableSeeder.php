<?php

use Illuminate\Database\Seeder;
use Kodeine\Acl\Models\Eloquent\Role;
use Kodeine\Acl\Models\Eloquent\Permission;
use App\User;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $operator = new Role();
        $operator->name = 'Operator';
        $operator->slug = 'operator';
        $operator->description = 'The manager of the system that can CRUD all entities';
        $operator->save();
        
        $patient = new Role();
        $patient->name = 'Patient';
        $patient->slug = 'patient';
        $patient->description = 'The user of the system that can read its reports and export them for private purposes';
        $patient->save();
        
        $permission = new Permission();
        $userManagingPermission = $permission->create([ 
            'name'        => 'user',
            'slug'        => [          // pass an array of permissions.
                'create'     => true,
                'view'       => true,
                'update'     => true,
                'delete'     => true,
                'send'       => true,
            ],
            'description' => 'manage user permissions'
        ]);
        $permission = new Permission();
        $operatorReportingPermission = $permission->create([ 
            'name'        => 'report',
            'slug'        => [          // pass an array of permissions.
                'create'     => true,
                'view'       => true,
                'update'     => true,
                'delete'     => true,
                'send'       => true,
                'export.pdf' => false,
                'export.mail'=> false,
            ],
            'description' => 'manage report operator permissions'
        ]);
        $permission = new Permission();
        $patientReportingPermission = $permission->create([ 
            'name'        => 'report.patient',
            'slug'        => [          // pass an array of permissions.
                'create'     => false,
                'update'     => false,
                'delete'     => false,
                'send'       => false,
                'export.pdf' => true,
                'export.mail'=> true,
            ],
            'inherit_id' => $operatorReportingPermission->getKey(),
            'description' => 'manage report permissions'
        ]);
        $operator->assignPermission([$userManagingPermission, $operatorReportingPermission]);
        $patient->assignPermission($patientReportingPermission);
        
        $admin = User::findOrFail(1);
        $admin->assignRole($operator);
    }
}
