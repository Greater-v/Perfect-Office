<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    @include('role-permission.nav-links')

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <div class="card mt-3">
                    <div class="card-header">
                        <h4>Permissions
                            <a href="{{ url('permissions/create') }}" class="btn btn-primary float-end">Add Permission</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('permissions.index') }}" method="GET">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Search by ID or name...." name="search" value="{{ $search }}">
                                <button class="btn btn-primary float-end" type="submit">Find</button>
                            </div>
                        </form>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $permission)
                                <tr>
                                    <td>{{ $permission->id }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td>
                                        <a href="{{ url('permissions/' . $permission->id . '/edit') }}" class="btn btn-success">Edit</a>
                                        {{-- <a href="{{ url('permissions/' . $permission->id . '/delete') }}" class="btn btn-danger mx-2"<a href="{{ url('permissions/' . $permission->id . '/delete') }}" class="btn btn-danger mx-2" 
                                            onclick="return confirm('Are you sure you want to delete this user ?');">
                                            Delete
                                        </a> --}}
                                        <a href="{{ url('permissions/' . $permission->id . '/delete') }}" class="btn btn-danger mx-2" data-toggle="modal" data-target="#confirmDeleteModal" data-url="{{ url('permissions/' . $permission->id . '/delete') }}">
                                            Delete
                                        </a> 
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {{ $permissions->links('pagination::bootstrap-4') }}
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="margin-left: 19rem;" >&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this permission ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <a href="#" class="btn btn-danger" id="confirmDeleteButton">Delete</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $('#confirmDeleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); 
            var url = button.data('url'); 
            var modal = $(this);
            modal.find('#confirmDeleteButton').attr('href', url);
        });
    </script>

</x-app-layout>