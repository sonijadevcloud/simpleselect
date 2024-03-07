@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow rounded-4">
                <div class="card-body px-4">
                    @if (session('success'))
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle"></i> {{ session('success') }}
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
                                <h2 class="fw-bold lh-1"><i class="bi bi-person-badge"></i> {{ __('Users management') }}</h3>
                                <h6 class="lh-1">{{ __('Here you can manage users in the system') }}</h6>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end align-items-center">
                                @can('AdminUsers-W')
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addUserModal"><i class="bi bi-plus-lg"></i> {{ __('Register new user') }}</button>
                                @endcan
                            </div>
                        </div>
                            <div class="table-responsive-sm mt-5">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ __('Name') }}</th>
                                        <th scope="col">{{ __('E-mail') }}</th>
                                        <th scope="col">{{ __('Phone') }}</th>
                                        <th scope="col">{{ __('Created at') }}</th>
                                        <th scope="col">{{ __('Updated at') }}</th>
                                        <th scope="col">{{ __('Status') }}</th>
                                        <th scope="col">{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider">
                                     @forelse ($users as $index => $user)
                                        <tr>
                                        <th scope="row">{{ $users->firstItem() + $index }}</th>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->created_at }}</td>
                                        <td>{{ $user->updated_at }}</td>
                                        <td class="text-center">
                                            @if($user->user_status == 'active')
                                                <span class="badge text-bg-success">{{ __('active') }}</span>
                                            @elseif($user->user_status == 'notactive')
                                                <span class="badge text-bg-dark">{{ __('notactive') }}</span>
                                            @elseif($user->user_status == 'blocked')
                                                <span class="badge text-bg-danger">{{ __('blocked') }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                        @if($user->name == 'sysadmin')
                                            <span class="text-danger fs-6" title="{{ __('Built-in account cannot be edited') }}">{{ __('Built-in account') }}</span>
                                        @elseif($user->id !== Auth::id())
                                            <!-- Przycisk do edycji usera -->
                                            @can('AdminUsers-W')
                                            <button class="btn btn-sm btn-secondary" title="{{ __('Edit user`s information') }}" data-bs-toggle="modal" data-bs-target="#editUserModal-{{ $user->id }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            <!-- Przycisk do zmiany hasła usera -->
                                            <button class="btn btn-sm btn-warning" title="{{ __('Change user`s password') }}" data-bs-toggle="modal" data-bs-target="#editUserPwModal-{{ $user->id }}">
                                                <i class="bi bi-key"></i>
                                            </button>
                                            @endcan
                                            <!-- Przycisk do włączania/wyłączania usera -->
                                            @can('AdminUsers-D')
                                                @if($user->user_status == 'active')
                                                    <button class="btn btn-sm btn-danger" title="{{ __('Turn off this user') }}" data-bs-toggle="modal" data-bs-target="#turnoffUserModal-{{ $user->id }}">
                                                        <i class="bi bi-power"></i>
                                                    </button>
                                                @elseif($user->user_status == 'notactive')
                                                    <button class="btn btn-sm btn-success" title="{{ __('Turn on this user') }}" data-bs-toggle="modal" data-bs-target="#turnonUserModal-{{ $user->id }}">
                                                        <i class="bi bi-power"></i>
                                                    </button>
                                                @endif
                                            @endcan
                                            @else
                                            <span title="{{ __('If you want to edit your own account information or make password changes - use the user settings for your account or ask another administrator to do it.') }}">{{ __('No actions available') }}</span>
                                            @endif
                                        </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">{{ __('No data in table Roles. Add your first role!') }}</td>
                                            </tr>
                                     @endforelse
                                    </tbody>
                                </table>
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination justify-content-center">
                                            {{ $users->links() }}
                                        </ul>
                                    </nav>
                            </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- ADDING USER MODAL -->
<div class="modal modal-lg fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addUserModalLabel">{{ __('Create new User') }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('users.store') }}" method="POST" id="addUserForm">
        @csrf
      <div class="mb-3">
        <label for="name" class="form-label">{{ __('Name and Surname') }}</label>
        <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
        <label for="email" class="form-label">{{ __('E-mail address') }}</label>
        <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
        <label for="phone" class="form-label">{{ __('Phone number') }}</label><br>
        <input type="tel" class="form-control phone-input-field" id="phone" name="phone" pattern="[0-9+()\s-]*">
        </div>
        <div class="mb-3">
        <label for="password" class="form-label">{{ __('Password') }}</label>
        <input type="password" class="form-control" id="password" name="password">
        <small id="passwordHelpBlock" class="form-text text-muted mt-4">
            <small id="pwCapitalLetter" class="form-text text-muted" data-text="{{ __('Minimum 1 Capital Letter') }}">• {{ __('Minimum 1 Capital Letter') }}</small><br>
            <small id="pwOneNumber" class="form-text text-muted" data-text="{{ __('Minimum One number') }}">• {{ __('Minimum One number') }}</small><br>
            <small id="pwSpecialChar" class="form-text text-muted" data-text="{{ __('Minimum 1 special character') }}">• {{ __('Minimum 1 special character') }}</small><br>
            <small id="pwEightchar" class="form-text text-muted" data-text="{{ __('Minimum 8 characters length') }}">• {{ __('Minimum 8 characters length') }}</small><br>
        </small>
        </div>
        <div class="mb-3">
        <label for="password_confirmation" class="form-label">{{ __('Password confirmation') }}</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
        <small><small id="pwConfirmok" class="form-text text-muted" data-text="{{ __('The new password and confirmation must be the same') }}">• {{ __('The new password and confirmation must be the same') }}</small></small>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
        <button type="submit" form="addUserForm" class="btn btn-success"><i class="bi bi-plus-lg"></i> {{ __('Register') }}</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- ----- -->

<!-- MODALS FOR EDITING USER -->
@foreach($users as $user)
<div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel-{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Edit user ID#') }}{{ $user->id }} - {{ $user->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form action="{{ route('users.update', $user->id) }}" method="POST" id="editUserForm-{{ $user->id }}">
                @csrf
                @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">{{ __('Name and Surname') }}</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                </div>
            <div class="mb-3">
                <label for="name" class="form-label">{{ __('E-mail address') }}</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                </div>
            <div class="mb-3">
                <label for="phonee" class="form-label">{{ __('Phone number') }}</label><br>
                <input type="tel" class="form-control phone-input-field" id="phonee" name="phone" pattern="[0-9+()\s-]*" value="{{ $user->phone }}">
                </div>
                <div class="mb-3">
                    <label for="role_id" class="form-label">{{ __('Role') }}</label>
                    <select class="form-select" id="role_id" name="role_id">
                        <option value="no-role">-- {{ __('Select role') }} --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ $user->roles->contains('id', $role->id) ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="submit" form="editUserForm-{{ $user->id }}" class="btn btn-primary"><i class="bi bi-floppy"></i> {{ __('Save') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach


<!-- ----- -->


<!-- MODALS FOR CHANGING USER PW-->
@foreach($users as $user)
<div class="modal fade" id="editUserPwModal-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="editUserPwModalLabel-{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Change password for ') }} {{ $user->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form action="{{ route('users.update', $user->id) }}" method="POST" id="editUserPwForm-{{ $user->id }}">
                @csrf
                @method('PUT')
            <div class="mb-3">
                <label for="passwordn" class="form-label">{{ __('New password') }}</label>
                <input type="password" class="form-control" id="passwordn{{$user->id}}" name="password" required>
                <small id="passwordHelpBlockn{{$user->id}}" class="form-text text-muted mt-4">
                    <small id="pwCapitalLettern{{$user->id}}" class="form-text text-muted" data-text="{{ __('Minimum 1 Capital Letter') }}">• {{ __('Minimum 1 Capital Letter') }}</small><br>
                    <small id="pwOneNumbern{{$user->id}}" class="form-text text-muted" data-text="{{ __('Minimum One number') }}">• {{ __('Minimum One number') }}</small><br>
                    <small id="pwSpecialCharn{{$user->id}}" class="form-text text-muted" data-text="{{ __('Minimum 1 special character') }}">• {{ __('Minimum 1 special character') }}</small><br>
                    <small id="pwEightcharn{{$user->id}}" class="form-text text-muted" data-text="{{ __('Minimum 8 characters length') }}">• {{ __('Minimum 8 characters length') }}</small><br>
                </small>
                </div>
            <div class="mb-3">
                <label for="passwordn_confirmation" class="form-label">{{ __('Repeat new password') }}</label>
                <input type="password" class="form-control" id="passwordn_confirmation{{$user->id}}" name="password_confirmation" required>
                <small><small id="pwConfirmokn{{$user->id}}" class="form-text text-muted" data-text="{{ __('The new password and confirmation must be the same') }}">• {{ __('The new password and confirmation must be the same') }}</small></small>
                </div>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="submit" form="editUserPwForm-{{ $user->id }}" class="btn btn-warning"><i class="bi bi-key"></i> {{ __('Set new passowrd') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password_confirmation');
    const capitalLetter = document.getElementById('pwCapitalLetter');
    const oneNumber = document.getElementById('pwOneNumber');
    const specialChar = document.getElementById('pwSpecialChar');
    const eightChar = document.getElementById('pwEightchar');
    const pwMatch = document.getElementById('pwConfirmok');


    function updateCriteria(element, isValid) {
        if (isValid) {
            element.classList.add('text-success');
            element.classList.remove('text-muted');
            element.textContent = '✓ ' + element.dataset.text; // Używamy '✓'
        } else {
            element.classList.remove('text-success');
            element.classList.add('text-muted');
            element.textContent = '• ' + element.dataset.text; // Używamy '•'
        }
    }

    function checkPasswordMatch() {
        const match = passwordInput.value === confirmPasswordInput.value;
        updateCriteria(pwMatch, match);
    }

    passwordInput.addEventListener('keyup', function() {
        const value = passwordInput.value;
        const hasCapitalLetter = /[A-Z]/.test(value);
        const hasOneNumber = /[0-9]/.test(value);
        const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(value);
        const hasEightChar = value.length >= 8;

        updateCriteria(capitalLetter, hasCapitalLetter);
        updateCriteria(oneNumber, hasOneNumber);
        updateCriteria(specialChar, hasSpecialChar);
        updateCriteria(eightChar, hasEightChar);

        // Sprawdzenie wielkiej litery
        if (hasCapitalLetter) {
            capitalLetter.classList.add('text-success');
            capitalLetter.classList.add('fw-bold');
            capitalLetter.classList.remove('text-muted');
        } else {
            capitalLetter.classList.remove('text-success');
            capitalLetter.classList.remove('fw-bold');
            capitalLetter.classList.add('text-muted');
        }

        // Sprawdzenie cyfry
        if (hasOneNumber) {
            oneNumber.classList.add('text-success');
            oneNumber.classList.add('fw-bold');
            oneNumber.classList.remove('text-muted');
        } else {
            oneNumber.classList.remove('text-success');
            oneNumber.classList.remove('fw-bold');
            oneNumber.classList.add('text-muted');
        }

        // Sprawdzenie znaku specjalnego
        if (hasSpecialChar) {
            specialChar.classList.add('text-success');
            specialChar.classList.add('fw-bold');
            specialChar.classList.remove('text-muted');
        } else {
            specialChar.classList.remove('text-success');
            specialChar.classList.remove('fw-bold');
            specialChar.classList.add('text-muted');
        }

        // Sprawdzenie długości
        if (hasEightChar) {
            eightChar.classList.add('text-success');
            eightChar.classList.add('fw-bold');
            eightChar.classList.remove('text-muted');
        } else {
            eightChar.classList.remove('text-success');
            eightChar.classList.remove('fw-bold');
            eightChar.classList.add('text-muted');
        }
    });

    confirmPasswordInput.addEventListener('keyup', checkPasswordMatch);

});
</script>
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
    const passwordInput = document.getElementById('passwordn{{$user->id}}');
    const confirmPasswordInput = document.getElementById('passwordn_confirmation{{$user->id}}');
    const capitalLetter = document.getElementById('pwCapitalLettern{{$user->id}}');
    const oneNumber = document.getElementById('pwOneNumbern{{$user->id}}');
    const specialChar = document.getElementById('pwSpecialCharn{{$user->id}}');
    const eightChar = document.getElementById('pwEightcharn{{$user->id}}');
    const pwMatch = document.getElementById('pwConfirmokn{{$user->id}}');


    function updateCriteria(element, isValid) {
        if (isValid) {
            element.classList.add('text-success');
            element.classList.remove('text-muted');
            element.textContent = '✓ ' + element.dataset.text; // Używamy '✓'
        } else {
            element.classList.remove('text-success');
            element.classList.add('text-muted');
            element.textContent = '• ' + element.dataset.text; // Używamy '•'
        }
    }

    function checkPasswordMatch() {
        const match = passwordInput.value === confirmPasswordInput.value;
        updateCriteria(pwMatch, match);
    }

    passwordInput.addEventListener('keyup', function() {
        const value = passwordInput.value;
        const hasCapitalLetter = /[A-Z]/.test(value);
        const hasOneNumber = /[0-9]/.test(value);
        const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(value);
        const hasEightChar = value.length >= 8;

        updateCriteria(capitalLetter, hasCapitalLetter);
        updateCriteria(oneNumber, hasOneNumber);
        updateCriteria(specialChar, hasSpecialChar);
        updateCriteria(eightChar, hasEightChar);

        // Sprawdzenie wielkiej litery
        if (hasCapitalLetter) {
            capitalLetter.classList.add('text-success');
            capitalLetter.classList.add('fw-bold');
            capitalLetter.classList.remove('text-muted');
        } else {
            capitalLetter.classList.remove('text-success');
            capitalLetter.classList.remove('fw-bold');
            capitalLetter.classList.add('text-muted');
        }

        // Sprawdzenie cyfry
        if (hasOneNumber) {
            oneNumber.classList.add('text-success');
            oneNumber.classList.add('fw-bold');
            oneNumber.classList.remove('text-muted');
        } else {
            oneNumber.classList.remove('text-success');
            oneNumber.classList.remove('fw-bold');
            oneNumber.classList.add('text-muted');
        }

        // Sprawdzenie znaku specjalnego
        if (hasSpecialChar) {
            specialChar.classList.add('text-success');
            specialChar.classList.add('fw-bold');
            specialChar.classList.remove('text-muted');
        } else {
            specialChar.classList.remove('text-success');
            specialChar.classList.remove('fw-bold');
            specialChar.classList.add('text-muted');
        }

        // Sprawdzenie długości
        if (hasEightChar) {
            eightChar.classList.add('text-success');
            eightChar.classList.add('fw-bold');
            eightChar.classList.remove('text-muted');
        } else {
            eightChar.classList.remove('text-success');
            eightChar.classList.remove('fw-bold');
            eightChar.classList.add('text-muted');
        }
    });

    confirmPasswordInput.addEventListener('keyup', checkPasswordMatch);

});
</script>
@endforeach

<!-- MODALS FOR TURNING OFF USERS -->
@foreach($users as $user)
<div class="modal fade" id="turnoffUserModal-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="turnoffUserModalLabel-{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Disable user #') }}{{ $user->id }} {{ __(' account') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ __('Are you sure you want to turn off ') }} <b>{{ $user->name }}</b> {{ __(' in system?')}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <form action="{{ route('users.update', $user->id) }}" method="POST" class="turnoffUserForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="user_status" value="notactive">
                    <button type="submit" class="btn btn-danger"><i class="bi bi-power"></i> {{ __('Yes, turn off') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- MODALS FOR TURNING ON USERS -->
@foreach($users as $user)
<div class="modal fade" id="turnonUserModal-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="turnonUserModalLabel-{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Enable user #') }}{{ $user->id }} {{ __(' account') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ __('Are you sure you want to turn on ') }} <b>{{ $user->name }}</b> {{ __(' in system?')}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <form action="{{ route('users.update', $user->id) }}" method="POST" class="turnonUserForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="user_status" value="active">
                    <button type="submit" class="btn btn-success"><i class="bi bi-power"></i> {{ __('Yes, turn on') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach


@endsection
