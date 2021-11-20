<div><b>Administrations Berechtigungen:</b></div>
<div class="ms-3">
    <x-util.checkbox id="{{ isset($role) ? $role->id : '' }}-adminSettingsShow-Ceckbox" name="permissions[]" value="admin.settings.show" checked="{{ isset($role) ? $role->hasPermissionTo('admin.settings.show') : false }}">
        {{ __('permission_names.admin.settings.show') }}
    </x-util.checkbox>
    <x-util.checkbox id="{{ isset($role) ? $role->id : '' }}-adminEditRolesCeckbox" name="permissions[]" value="admin.edit-roles" checked="{{ isset($role) ? $role->hasPermissionTo('admin.edit-roles') : false }}">
        {{ __('permission_names.admin.edit-roles') }}
    </x-util.checkbox>
</div>

<div><b>Kassenwart Berechtigungen</b></div>
<div class="ms-3">
    <x-util.checkbox id="{{ isset($role) ? $role->id : '' }}-treasurerShow-Ceckbox" name="permissions[]" value="treasurer.show" checked="{{ isset($role) ? $role->hasPermissionTo('treasurer.show') : false }}">
        {{ __('permission_names.treasurer.show') }}
    </x-util.checkbox>
    <x-util.checkbox id="{{ isset($role) ? $role->id : '' }}-treasurerReject_payment-Ceckbox" name="permissions[]" value="treasurer.reject_payment" checked="{{ isset($role) ? $role->hasPermissionTo('treasurer.reject_payment') : false }}">
        {{ __('permission_names.treasurer.reject_payment') }}
    </x-util.checkbox>
    <x-util.checkbox id="{{ isset($role) ? $role->id : '' }}-treasurerValidate_payment-Ceckbox" name="permissions[]" value="treasurer.validate_payment" checked="{{ isset($role) ? $role->hasPermissionTo('treasurer.validate_payment') : false }}">
        {{ __('permission_names.treasurer.validate_payment') }}
    </x-util.checkbox>
</div>
