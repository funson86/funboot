RBAC Role-based access control
-----------

Table of contents
- Menu Permission & Data Permission & Department Permission
- Menu Permission
- Role
- User Role


### Menu Permission & Data Permission & Department Permission

Permissions include menu permissions, data permissions and department permissions. At present, menu permissions are controlled by roles, data permissions are controlled by role types, and department permissions are not integrated temporarily.

- Menu Permission：The menu on the top and left displays if the permission is assigned
- Data Permission：Click the menu, you can only see the data of the specified store
- Department Permission：Click the menu, you can only see the data of the Department under the specified store(Developing0

### Menu Permission

Menu Permission has 4 level

- Level 1 on the top, subsystem usually
- Level 2 on the left
- Level 3 on the left for sub menu
- Level 4 is for button permission

Permission control support wildcard. For example, input /base/role/edit* in the path of role edit permission, the corresponding new window editing and list page quick editing will be controlled by the change permission, custom method naming also needs to be named in this way 

### Role

Funboot contains super admin, admin, store admin, frontend user by default.

- Super admin own all menu permissions and all store data permissions.
- Admin menu permission need to be assigned, and can view all store data. For example, if he has user menu permission, then he can view all store users.
- Store admin can only view the data of store owned, and menu permission need to be assigned.
- Frontend user cannot login in backend

```php
        'authSystem' => [
            'class' => 'common\components\base\AuthSystem',
            'superAdminUsernames' => ['admin', 'superadmin'], //super admin username
            'maxAdminRoleId' => 49, //Admin max role ID
            'maxStoreRoleId' => 99, //Max role ID that can login in backend
        ],
```

Different role type is controlled by ID range, Super admin ID is 1, Admin ID is 2 to 49, Store Admin ID is 50 to 99, Frontend User ID is greater than 100.

### User Role

Edit user in the backend to set user role.

