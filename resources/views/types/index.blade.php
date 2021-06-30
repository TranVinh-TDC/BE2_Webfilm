@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-end mb-2">
        <div class="d-flex" style="padding-right:150px">
            <form class="form-inline my-2 my-lg-0" action="{{ route('search.types') }}" method="GET">
                <input class="form-control mr-sm-2" id="search" name="search" type="text" placeholder="Search"
                    value="{{ request()->query('search') }}">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
        <div class="btn btn-success float-right " data-toggle="modal" onclick="addType()">
            Add type
        </div>
    </div>

    <div class="card card-default">
        @include('partials.errors')
        <div class="card-header">types</div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <th>Name</th>
                    <th>Films Count</th>
                    <th></th>
                </thead>
                <tbody>
                    @forelse ($types as $type)
                        <tr>
                            <td>
                                {{ $type->name }}
                            </td>
                            <td>
                                @if ($type->films)
                                    {{ $type->films()->count() }}
                                @endif
                            </td>
                            <td>
                                <div class="btn btn-primary  btn-sm float-right" data-toggle="modal"
                                    onclick="deleteType({{ $type->id }})">
                                    Delete
                                </div>
                                <div class="btn btn-danger mr-2 btn-sm float-right" data-toggle="modal"
                                    onclick="updateType({{ $type->id }})">
                                    Edit
                                </div>

                            </td>
                        </tr>
                    @empty
                        <p class="text-center"> No results found for query
                            <strong>{{ request()->query('search') }}</strong>
                        </p>
                    @endforelse

                </tbody>
            </table>
            {{ $types->appends(['search' => request()->query('search')])->links() }}
        </div>
    </div>
    <!-- Modal update vs create -->
    <div class="modal fade" id="modal-type" tabindex="-1" role="dialog" aria-labelledby="modal-type" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Add type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- start form --}}
                    <form id="form-type" method="POST">
                        {{-- fields --}}
                        @csrf
                        <input type="hidden" id="_method" name="_method" value="">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Act">
                        </div>
                        {{-- end flied --}}
                        {{-- button --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" id="button-form" class="btn btn-primary">Save changes</button>
                        </div>
                        {{-- end button --}}
                    </form>
                    {{-- end form --}}
                </div>
            </div>
        </div>
    </div>
    {{-- end modal --}}
    {{-- Modal delete --}}
    <div class="modal fade" id="modal-type-deleted" tabindex="-1" role="dialog" aria-labelledby="modal-type-deleted"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Delete type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- start form --}}
                    <h4 class="text-center">Are you deleting this type ?</h4>
                    <form id="form-type-deleted" method="POST">
                        {{-- fields --}}
                        @csrf
                        @method("DELETE")
                        {{-- end flied --}}
                        {{-- button --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" id="button-form" class="btn btn-primary">Yes</button>
                        </div>
                        {{-- end button --}}
                    </form>
                    {{-- end form --}}
                </div>
            </div>
        </div>
    </div>
    {{-- end modal delete --}}
@endsection

@section('scripts')
<script>
    //==================================================================
    //type
    //===================================================================
    // Add type
    function addType() {
        $('#modal-type').modal('show');
        $('#form-type').on('submit', function(e) {
            e.preventDefault()
            path = "{{ route('types.store') }}"; //set up path
            ajax(path);
        });
    }
    //Update type
    function updateType(id) {
        let path = "types/" + id + "/edit";
        //get val
        $.get(path, function(type) {
            //set fileds
            $('#name').val(type.name);
        })
        //modal vs ajax
        $('#modal-type').modal('show');
        $('#form-type').on('submit', function(e) {
            e.preventDefault()

            path = "types/" + id; //set up path
            $('#_method').val("PUT"); // set up method

            ajax(path);
        });
    }
    //Delete type
    function deleteType(id) {
        $('#modal-type-deleted').modal('show');
        $('#form-type-deleted').on('submit', function(e) {
            e.preventDefault();
            path = "types/" + id; //set up path
            console.log(id);
            $.ajax({
                type: "POST",
                url: path,
                data: $('#form-type-deleted').serialize(),
                success: function(reponse) {
                    $('#modal-type-deleted').modal('hide');
                    alert("Sended sever");
                    location.reload(true);
                },
                error: function(error) {
                    alert("Not send");
                    $('#modal-type-deleted').modal('hide');
                    console.log(error);
                }
            });
        });
    }

    //=================================================================
    // Ajax custom
    function ajax(path) {
        $.ajax({
            type: "POST",
            url: path,
            data: $('#form-type').serialize(),
            success: function(reponse) {
                $('#modal-type').modal('hide');
                alert("Sended sever");
                location.reload(true);
            },
            error: function(error) {
                alert("Not send");
                $('#modal-type').modal('hide');
                console.log(error);
            }
        });
    }
</script>
@endsection
