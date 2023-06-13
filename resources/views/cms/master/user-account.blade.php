@extends('cms.layouts.app', ['pageName' => 'User'])

@section('content')
<section class="section">
    <div class="mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="bi bi-plus-lg"></i> User Account
        </button>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered w-100" id="table">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th width="10%" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $idx => $user)
                        <tr>
                            <td><b>{{ $idx+1 }}</b></td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="text-center">
                                <button class="btn btn-warning" onclick="getUserDetail('{{ $user->id }}')">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-danger" {{ Auth::user()->id == $user->id ? 'disabled' : '' }} onclick="deleteUser('{{ $user->id }}')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<div class="modal fade text-left" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel1">
                    Add Data
                </h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-4">
                    <labe class="form-label">Name</label>
                    <input type="text" class="form-control name">
                </div>
                <div class="form-group mb-4">
                    <labe class="form-label">Email</label>
                    <input type="email" class="form-control email">
                </div>
                <div class="form-group mb-4">
                    <labe class="form-label">Password</label>
                    <input type="password" class="form-control password">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
                <button type="button" class="btn btn-primary ms-1" onclick="storeUser()">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Submit</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-left" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel1">
                    Edit Data
                </h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" class="form-control id">
                <div class="form-group mb-4">
                    <labe class="form-label">Name</label>
                    <input type="text" class="form-control name">
                </div>
                <div class="form-group mb-4">
                    <labe class="form-label">Email</label>
                    <input type="email" class="form-control email">
                </div>
                <div class="form-group mb-4">
                    <labe class="form-label">Password</label>
                    <input type="password" class="form-control password">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
                <button type="button" class="btn btn-primary ms-1" onclick="updateUser()">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Submit</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $('#table').DataTable({
        order: []
    })

    const storeUser = () => {
        let modal = $('#addModal')

        $.ajax({
            type: 'POST',
            url: '/cms/user',
            data: {
                _token: '{{ csrf_token() }}',
                name: modal.find('.name').val(),
                email: modal.find('.email').val(),
                password: modal.find('.password').val()
            },
            success: function(result) {
                if(result.status == 'OK') {
                    location.reload()
                } else {
                    alert(result.message)
                }
            },
            error: function(error) {
                if(error.responseJSON) {
                    alert(error.responseJSON.message)
                }
            }
        })
    }

    const getUserDetail = (userId) => {
        let modal = $('#editModal')

        $.ajax({
            type: 'GET',
            url: '/cms/user/detail',
            data: {
                user_id: userId
            },
            success: function(result) {
                if(result.status == 'OK') {
                    modal.find('.id').val(result.result.id)
                    modal.find('.name').val(result.result.name)
                    modal.find('.email').val(result.result.email)

                    modal.modal('show')
                } else {
                    alert(result.message)
                }
            },
            error: function(error) {
                if(error.responseJSON) {
                    alert(error.responseJSON.message)
                }
            }
        })
    }

    const updateUser = () => {
        let modal = $('#editModal')

        $.ajax({
            type: 'PUT',
            url: '/cms/user',
            data: {
                _token: '{{ csrf_token() }}',
                user_id: modal.find('.id').val(),
                name: modal.find('.name').val(),
                email: modal.find('.email').val(),
                password: modal.find('.password').val()
            },
            success: function(result) {
                if(result.status == 'OK') {
                    location.reload()
                } else {
                    alert(result.message)
                }
            },
            error: function(error) {
                if(error.responseJSON) {
                    alert(error.responseJSON.message)
                }
            }
        })
    }

    const deleteUser = (userId) => {
        if(confirm('Yakin hapus user ini?')) {
            $.ajax({
                type: 'DELETE',
                url: '/cms/user',
                data: {
                    _token: '{{ csrf_token() }}',
                    user_id: userId
                },
                success: function(result) {
                    if(result.status == 'OK') {
                        location.reload()
                    } else {
                        alert(result.message)
                    }
                },
                error: function(error) {
                    if(error.responseJSON) {
                        alert(error.responseJSON.message)
                    }
                }
            })
        }
    }
</script>
@endsection