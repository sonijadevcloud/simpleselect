@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow rounded-4">
                <div class="card-body px-4">
                    @if (session('permission_success'))
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle"></i> {{ session('permission_success') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <i class="bi bi-bug"></i> {{ $error }}
                                @endforeach
                        </div>
                    @endif
                        <div class="row">
                            <div class="col-md-6">
                                <h2 class="fw-bold lh-1"><i class="bi bi-diagram-3"></i> {{ __('Permissions management') }}</h3>
                                <h6 class="lh-1">{{ __('Here you can manage permissions in the system. Permissions are defined types of access and permissions, which are then assigned to a role. For example, the ability to read and write notifications. Keep in mind that removing permissions can damage the application`s logic and cause your users a lot of problems in their daily work.') }}</h6>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end align-items-center">
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#createPermissionModal"><i class="bi bi-plus-lg"></i> {{ __('Add new permission') }}</button>
                            </div>
                        </div>
                            <div class="table-responsive-sm mt-5">
                                <table class="table table-bordered table-striped table-hover" id="permissionsTable">
                                    <thead class="table-dark">
                                        <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ __('Permission name') }}</th>
                                        <th scope="col">{{ __('Permission description') }}</th>
                                        <th scope="col">{{ __('Created at') }}</th>
                                        <th scope="col">{{ __('Updated at') }}</th>
                                        <th scope="col">{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider">
                                     @forelse ($permissions as $index => $permission)
                                        <tr>
                                        <th scope="row">#{{ $index }}</th>
                                        <td>{{ $permission->name }}</td>
                                        <td>{{ $permission->title }}</td>
                                        <td>{{ $permission->created_at }}</td>
                                        <td>{{ $permission->updated_at }}</td>
                                        <td class="text-center">
                                            <!-- Przycisk do edycji roli -->
                                            <button class="btn btn-sm btn-secondary" title="{{ __('Edit permission') }}" data-bs-toggle="modal" data-bs-target="#editPermissionModal-{{ $permission->id }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            <!-- Przycisk do usuwania roli -->
                                            <button class="btn btn-sm btn-danger" title="{{ __('Delete permission') }}" data-bs-toggle="modal" data-bs-target="#deletePermissionModal-{{ $permission->id }}">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                            
                                            <!-- Modal usuwania uprawnienia -->
                                            <div class="modal fade" id="deletePermissionModal-{{ $permission->id }}" tabindex="-1" aria-labelledby="deletePermissionModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">{{ __('Delete permission ID#' . $permission->id) }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-start">
                                                            {{ __('Are you sure you want to delete permission ') }} <b>{{ $permission->name }}</b> {{ __(' in system?')}}
                                                        </div>
                                                            <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" class="deletePermissionForm">
                                                                @csrf
                                                                @method('DELETE')
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                                                <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i> {{ __('Yes, delete') }}</button>
                                                                </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- ############################ -->

                                            

                                            <!-- Modal edycji uprawnienia -->
                                            <div class="modal fade" id="editPermissionModal-{{ $permission->id }}" tabindex="-1" aria-labelledby="editPermissionModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editPermissionModalLabel">{{ __('Edit permission ID#' . $permission->id) }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-start">
                                                    <form method="POST" action="{{ route('permissions.update', $permission->id) }}">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="form-group mb-3">
                                                                            <label for="name">{{ __('Name') }}</label>
                                                                            <input type="text" class="form-control" id="name" name="name" value="{{ $permission->name }}" required>
                                                                        </div>
                                                                        <div class="form-group mb-3">
                                                                            <label for="title">{{ __('Title/description') }}</label>
                                                                            <input type="text" class="form-control" id="title" name="title" value="{{ $permission->title }}" required>
                                                                        </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                                                    <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> {{ __('Save') }}</button>
                                                                    </form>
                                                                </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- ############################ -->


                                        </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">{{ __('No data in table Roles. Add your first role!') }}</td>
                                            </tr>
                                     @endforelse
                                    </tbody>
                                </table>
                            </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- ### -->
<!-- TABELA OD UPRAWNIEŃ -->

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow rounded-4">
                <div class="card-body px-4">
                    @if (session('role_success'))
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle"></i> {{ session('role_success') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <i class="bi bi-bug"></i> {{ $error }}
                                @endforeach
                        </div>
                    @endif
                        <div class="row">
                            <div class="col-md-6">
                                <h2 class="fw-bold lh-1"><i class="bi bi-person-fill-lock"></i> {{ __('Roles management') }}</h3>
                                <h6 class="lh-1">{{ __('Here you can manage roles in the system. A role is a defined group with information on what users assigned to it can do in the application and what accesses they have. Remember to prudently manage roles and the permissions assigned to them. Careless management can corrupt application logic and cause tweoim users a lot of problems while working.') }}</h6>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end align-items-center">
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#createRoleModal"><i class="bi bi-plus-lg"></i> {{ __('Add new role') }}</button>
                            </div>
                        </div>
                            <div class="table-responsive-sm mt-5">
                            <table class="table table-bordered table-striped table-hover" id="rolesTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ __('Role name') }}</th>
                                        <th scope="col">{{ __('Role description') }}</th>
                                        <th scope="col">{{ __('Permissions') }}</th>
                                        <th scope="col">{{ __('Created at') }}</th>
                                        <th scope="col">{{ __('Updated at') }}</th>
                                        <th scope="col">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    @forelse ($roles as $index => $role)
                                        <tr>
                                            <th scope="row">#{{ $index }}</th>
                                            <td>{{ $role->name }}</td>
                                            <td>{{ $role->title }}</td>
                                            <td>
                                                @php
                                                    $abilitiesCount = $role->abilities->count();
                                                @endphp
                                                @foreach ($role->abilities->take(4) as $ability)
                                                    <small><span class="badge text-bg-primary">{{ $ability->name }}</span></small>
                                                @endforeach
                                                @if ($abilitiesCount > 4)
                                                    <small><span class="badge text-bg-secondary">+ {{ $abilitiesCount - 4 . ' more'}}</span></small>
                                                @endif
                                            </td>
                                            <td>{{ $role->created_at }}</td>
                                            <td>{{ $role->updated_at }}</td>
                                            <td class="text-center">
                                            <!-- Przycisk do edycji roli -->
                                            <button class="btn btn-sm btn-secondary" title="{{ __('Edit role') }}" data-bs-toggle="modal" data-bs-target="#editRoleModal-{{ $role->id }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            <!-- Przycisk do wyświetlenie przypisanych userów -->
                                            <button class="btn btn-sm btn-primary" title="{{ __('Show assigned users') }}" data-bs-toggle="modal" data-bs-target="#assignedUsersToRoleModal-{{ $role->id }}">
                                                <i class="bi bi-people-fill"></i>
                                            </button>

                                            <!-- Przycisk do usuwania roli -->
                                            <button class="btn btn-sm btn-danger" title="{{ __('Delete role') }}" data-bs-toggle="modal" data-bs-target="#deleteRoleModal-{{ $role->id }}">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                            
                                            <!-- Modal usuwania roli -->
                                            <div class="modal fade" id="deleteRoleModal-{{ $role->id }}" tabindex="-1" aria-labelledby="deleteRoleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">{{ __('Delete role ID#' . $role->id) }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-start">
                                                            {{ __('Are you sure you want to delete role ') }} <b>{{ $role->name }}</b> {{ __(' in system?')}}
                                                        </div>
                                                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="deleteRoleForm">
                                                                @csrf
                                                                @method('DELETE')
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                                                <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i> {{ __('Yes, delete') }}</button>
                                                                </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- ############################ -->
                                            

                                            <!-- Modal przypisanych userów do roli -->
                                            <div class="modal fade" id="assignedUsersToRoleModal-{{ $role->id }}" tabindex="-1" aria-labelledby="assignedUsersToRoleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">{{ __('Users assigned to the role ' . $role->name) }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-start">
                                                            <p>{{ __('Below is the list of users assigned to the role ( ') }} <b>{{ $role->name }}</b> ) :</p>
                                                            @if($role->users->isNotEmpty())
                                                                <ol>
                                                                    @foreach($role->users as $user)
                                                                        <li>{{ $user->name }}</li>
                                                                    @endforeach
                                                                </ol>
                                                            @else
                                                                <p class="text-warning text-center">{{ __('No users assigned to this role') }}</p>
                                                            @endif
                                                        </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- ############################ -->

                                            

                                            <!-- Modal edycji roli -->
                                            <div class="modal modal-lg fade" id="editRoleModal-{{ $role->id }}" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editRoleModalLabel">{{ __('Edit role ID#' . $role->id) }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-start">
                                                <form method="POST" action="{{ route('roles.update', $role->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group mb-3">
                                                        <label for="name">{{ __('Name') }}</label>
                                                        <input type="text" class="form-control" id="name" name="name" value="{{ $role->name }}" required>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="title">{{ __('Title/description') }}</label>
                                                        <input type="text" class="form-control" id="title" name="title" value="{{ $role->title }}" required>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label>{{ __('Permissions') }}</label><br>
                                                        <table id="permissionsTable" class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>{{ __('Admit') }}</th> 
                                                                    <th>{{ __('Name') }}</th>
                                                                    <th>{{ __('Title') }}</th> 
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($permissions as $permission)
                                                                <tr>
                                                                    <td>
                                                                        <div class="form-check form-switch">
                                                                            <input class="form-check-input permission-checkbox mx-auto" type="checkbox" role="switch" id="flexSwitchCheckDefault{{ $permission->id }}" name="permissions[]" value="{{ $permission->name }}" @if($role->abilities->contains('name', $permission->name)) checked @endif>
                                                                        </div>
                                                                    </td>
                                                                    <td>{{ $permission->name }}</td>
                                                                    <td>{{ $permission->title }}</td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="selectAllCheckbox">
                                                            <label class="form-check-label" for="selectAllCheckbox">{{ __('Grant all of the above permissions to this role') }}</label>
                                                        </div>
                                                    </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                                            <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> {{ __('Save') }}</button>
                                                            </form>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- ############################ -->
                                            
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">{{ __('No data in table Roles. Add your first role!') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ### -->

<!-- Create Permission Modal -->
<div class="modal fade" id="createPermissionModal" tabindex="-1" role="dialog" aria-labelledby="createPermissionModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createPermissionModalLabel">{{ __('Create permission') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Form for Creating Permission -->
        <form method="POST" action="{{ route('permissions.store') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="name">{{ __('Name') }}</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="title">{{ __('Title/description') }}</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="submit" class="btn btn-success"><i class="bi bi-plus-lg"></i> {{ __('Create') }}</button>
                </form>
            </div>
      </div>
    </div>
  </div>
</div>


<!-- ### -->

<!-- Create Role Modal -->
<div class="modal modal-lg fade" id="createRoleModal" tabindex="-1" role="dialog" aria-labelledby="createRoleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createRoleModalLabel">{{ __('Create a role') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Form for Creating Permission -->
                <form method="POST" action="{{ route('roles.store') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="name">{{ __('Name') }}</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="title">{{ __('Title/description') }}</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group mb-3">
                    <label>{{ __('Permissions') }}</label><br>
                    <table id="permissionsTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('Admit') }}</th> 
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Title') }}</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permissions as $permission)
                            <tr>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input permission-checkboxcreate mx-auto" type="checkbox" role="switch" id="flexSwitchCheckDefaultCreate{{ $permission->id }}" name="permissions[]" value="{{ $permission->name }}">
                                    </div>
                                </td>
                                <td>{{ $permission->name }}</td>
                                <td>{{ $permission->title }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                        <div class="form-check ml-2">
                            <input class="form-check-input" type="checkbox" id="selectAllCheckboxCreate">
                            <label class="form-check-label" for="selectAllCheckboxCreate">{{ __('Grant all of the above permissions to this role') }}</label>
                        </div>
                    </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="submit" class="btn btn-success"><i class="bi bi-plus-lg"></i> {{ __('Create') }}</button>
                </form>
            </div>
      </div>
    </div>
  </div>
</div>




@endsection
