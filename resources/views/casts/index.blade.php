@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-end mb-2">
        <div class="d-flex" style="padding-right:150px">
            <form class="form-inline my-2 my-lg-0" action="{{ route('search.casts') }}" method="GET">
                <input class="form-control mr-sm-2" id="search" name="search" type="text" placeholder="Search"
                    value="{{ request()->query('search') }}">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
        <a href="{{ route('casts.create') }}" class="btn btn-success float-right ">
            Add cast
        </a>
    </div>
    <div class="card card-default">
        @include('partials.errors')
        <div class="card-header">casts</div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <th>Image</th>
                    <th>Name</th>
                    <th>cast count</th>
                    <th></th>
                </thead>
                <tbody>
                    @forelse ($casts as $cast)
                        <tr>
                            <td>
                                ​<picture>
                                    <source srcset="{{ url('storage/' . $cast->image) }}" type="image/svg+xml">
                                    <img src="{{ url('storage/' . $cast->image) }}" width="70px"
                                        class="img-fluid img-thumbnail mx-auto"
                                        alt="{{ url('storage/' . $cast->image) }} ">
                                </picture>
                            </td>
                            <td>
                                {{ $cast->name }}
                            </td>
                            <td>
                                {{ $cast->films->count() }}
                            </td>
                            <td>
                                <div class="btn btn-primary  btn-sm float-right" data-toggle="modal"
                                    onclick="deleteCast({{ $cast->id }})">
                                    Delete
                                </div>
                                <a href="{{ route('casts.edit', $cast->id) }}"
                                    class="btn btn-danger mr-2 btn-sm float-right">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <p class="text-center"> No results found for query
                            <strong>{{ request()->query('search') }}</strong>
                        </p>
                    @endforelse

                </tbody>
            </table>
             {{ $casts->appends(['search' => request()->query('search')])->links() }}

        </div>
    </div>

    {{-- Modal delete --}}
    <div class="modal fade" id="modal-cast-deleted" tabindex="-1" role="dialog" aria-labelledby="modal-cast-deleted"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Delete cast</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- start form --}}
                    <h4 class="text-center">Are you deleting this cast ?</h4>
                    <form id="form-cast-deleted" method="POST">
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
    //cast
    //===================================================================
    //Delete cast
    function deleteCast(id) {
        $('#modal-cast-deleted').modal('show');
        $('#form-cast-deleted').on('submit', function(e) {
            e.preventDefault();
            path = "casts/" + id; //set up path
            $.ajax({
                type: "POST",
                url: path,
                data: $('#form-cast-deleted').serialize(),
                success: function(reponse) {
                    $('#modal-cast-deleted').modal('hide');
                    alert("Sended sever");
                    location.reload(true);
                },
                error: function(error) {
                    alert("Not send");
                    $('#modal-cast-deleted').modal('hide');
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
            data: $('#form-cast').serialize(),
            success: function(reponse) {
                $('#modal-cast').modal('hide');
                alert("Sended sever");
                location.reload(true);
            },
            error: function(error) {
                alert("Not send");
                $('#modal-cast').modal('hide');
                console.log(error);
            }
        });
    }
</script>
@endsection
