@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow rounded-4">
                <div class="card-body px-4">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                        </div>
                    @endif
                        <div class="row">
                            <div class="col-md-6">
                                <h2 class="fw-bold lh-1">{{ __('Privilege management') }}</h3>
                                <h6 class="lh-1">{{ __('Here you can manage roles and permissions in the system') }}</h6>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end align-items-center">
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addRoleModal"><i class="bi bi-plus-lg"></i> {{ __('Add new role') }}</button>
                            </div>
                        </div>
                            <div class="table-responsive-sm mt-5">
                                <table class="table table-bordered table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ __('Role name') }}</th>
                                        <th scope="col">{{ __('Role description') }}</th>
                                        <th scope="col">{{ __('Created at') }}</th>
                                        <th scope="col">{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider">
                                     @forelse ($roles as $index => $role)
                                        <tr>
                                        <th scope="row">#{{ $roles->firstItem() + $index }}</th>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->description }}</td>
                                        <td>{{ $role->created_at }}</td>
                                        <td class="text-center">
                                            <!-- Przycisk do edycji roli -->
                                            <button class="btn btn-sm btn-secondary" title="{{ __('Edit role') }}" data-bs-toggle="modal" data-bs-target="#editRoleModal-{{ $role->id }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            <!-- Przycisk do usuwania roli -->
                                            <button class="btn btn-sm btn-danger" title="{{ __('Delete role') }}" data-bs-toggle="modal" data-bs-target="#deleteRoleModal-{{ $role->id }}">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>

                                            <!-- Przycisk do zmiany uprawnień -->
                                            <button class="btn btn-sm btn-primary" title="{{ __('Show or customize privileges for this role') }}" data-bs-toggle="modal" data-bs-target="#changePermissionsModal-{{ $role->id }}">
                                                <i class="bi bi-shield-fill-plus"></i>
                                            </button>
                                        </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">{{ __('No data in table Roles. Add your first role!') }}</td>
                                            </tr>
                                     @endforelse
                                    </tbody>
                                </table>
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination justify-content-center">
                                            {{ $roles->links() }}
                                        </ul>
                                    </nav>
                            </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- ADDING ROLE MODAL -->
<div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addRoleModalLabel">{{ __('Add new role') }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('roles.store') }}" method="POST" id="addRoleForm">
        @csrf
      <div class="mb-3">
        <label for="name" class="form-label">Role name</label>
        <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="mb-3">
        <label for="description" class="form-label">Role description</label>
        <textarea class="form-control" id="description" name="description" rows="2"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
        <button type="submit" form="addRoleForm" class="btn btn-success"><i class="bi bi-check2"></i> {{ __('Save') }}</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- ----- -->

<!-- MODALS FOR EDITING ROLE -->
@foreach($roles as $role)
<div class="modal fade" id="editRoleModal-{{ $role->id }}" tabindex="-1" role="dialog" aria-labelledby="editRoleModalLabel-{{ $role->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Edit role ID-') }}{{ $role->id }} - {{ $role->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form action="{{ route('roles.update', $role->id) }}" method="POST" id="editRoleForm-{{ $role->id }}">
                @csrf
                @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Role name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $role->name }}">
                </div>
                <div class="mb-3">
                <label for="description" class="form-label">Role description</label>
                <textarea class="form-control" id="description" name="description" rows="2">{{ $role->description }}</textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="submit" form="editRoleForm-{{ $role->id }}" class="btn btn-success"><i class="bi bi-check2"></i> {{ __('Save') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach


<!-- ----- -->

<!-- MODALS FOR DELETING ROLES -->
@foreach($roles as $role)
<div class="modal fade" id="deleteRoleModal-{{ $role->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteRoleModalLabel-{{ $role->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Delete role ID-') }}{{ $role->id }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ __('Do you want to delete the role') }} <b>"{{ $role->name }}"</b>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="deleteRoleForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash-fill"></i> {{ __('Yes') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach


<!-- ----- -->

<!-- MODALS FOR PERMISSIONS DETAILS -->
@foreach($roles as $role)
<div class="modal fade" id="changePermissionsModal-{{ $role->id }}" tabindex="-1" role="dialog" aria-labelledby="changePermissionsModalLabel-{{ $role->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Permissions details for role ID-') }}{{ $role->id }} - {{ $role->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
            </div>
        </div>
    </div>
</div>
@endforeach


<!-- ----- -->


@endsection
