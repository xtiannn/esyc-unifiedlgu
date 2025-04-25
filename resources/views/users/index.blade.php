<x-app-layout>
    @section('title', 'User Management')

    <div class="row">
        <div class="col-md-10 mb-3">
            <h1>User List</h1>
        </div>
        <div class="col-md-2">
            <button type="button" role="button" class="btn btn-success mt-2" data-bs-toggle="modal"
                data-bs-target="#addUserModal">
                <i class="fa fa-user-plus mr-2"></i>
                Add User
            </button>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table datatable table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center" scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th class="text-center" scope="col">Role</th>
                    <th class="text-center" scope="col">Date Created</th>
                    <th class="text-center" scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="text-center" data-label="#">{{ $loop->iteration }}.</td>
                        <td data-label="Name">
                            {{ Str::title($user->last_name . ', ' . $user->first_name . ' ' . $user->middle_name) }}
                        </td>
                        <td data-label="Email">{{ $user->email }}</td>
                        <td class="text-center" data-label="Role">{{ $user->role }}</td>
                        <td class="text-center" data-label="DateCreated">
                            {{ $user->created_at ? $user->created_at->format('F d, Y') : 'N/A' }}
                        </td>
                        <td class="text-center" data-label="Action">
                            <button class="btn btn-primary btn-sm editUserBtn" data-bs-toggle="modal"
                                data-id="{{ $user->id }}" data-first_name="{{ $user->first_name }}"
                                data-middle_name="{{ $user->middle_name }}" data-last_name="{{ $user->last_name }}"
                                data-email="{{ $user->email }}" data-role="{{ $user->role }}"
                                data-mobile="{{ $user->mobile }}" data-birth_date="{{ $user->birth_date }}"
                                data-sex="{{ $user->sex }}" data-occupation="{{ $user->occupation }}"
                                data-address="{{ $user->address }}" data-bs-target="#editUserModal">
                                <i class="fa fa-edit"></i>
                            </button>

                            {{-- Reusable Delete Button --}}
                            @include('components.delete-button', [
                                'id' => $user->id,
                                'route' => route('users.destroy', $user->id),
                                'itemName' => $user->name,
                            ])
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>



    @include('users.modals.addUser')



</x-app-layout>
