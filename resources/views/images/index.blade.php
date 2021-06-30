@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-end mb-2">
        <div class="d-flex" style="padding-right:150px">
            <form class="form-inline my-2 my-lg-0" action="{{ route('search.images') }}" method="GET">
                <input class="form-control mr-sm-2" id="search" name="search" type="text" placeholder="Search"
                    value="{{ request()->query('search') }}">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
        <a href="{{ route('images.create') }}" class="btn btn-success float-right ">
            Add image
        </a>
    </div>
    <div class="card card-default">
        @include('partials.errors')
        <div class="card-header">images</div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <th>Image</th>
                    <th>image count</th>
                    <th></th>
                </thead>
                <tbody>
                    @forelse ($images as $image)
                        <tr>
                            <td>
                                ​<picture>
                                    <source srcset="{{ url('storage/' . $image->image) }}" type="image/svg+xml">
                                    <img src="{{ url('storage/' . $image->image) }}" width="70px"
                                        class="img-fluid img-thumbnail mx-auto"
                                        alt="{{ url('storage/' . $image->image) }} ">
                                </picture>
                            </td>
                            <td>
                                {{ $image->film->original_name }}
                            </td>
                            <td>
                                <div class="btn btn-primary  btn-sm float-right" data-toggle="modal"
                                    onclick="deleteImage({{ $image->id }})">
                                    Delete
                                </div>
                                <a href="{{ route('images.edit', $image->id) }}"
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
             {{ $images->appends(['search' => request()->query('search')])->links() }}
        </div>
    </div>

    {{-- Modal delete --}}
    <div class="modal fade" id="modal-image-deleted" tabindex="-1" role="dialog" aria-labelledby="modal-image-deleted"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Delete image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- start form --}}
                    <h4 class="text-center">Are you deleting this image ?</h4>
                    <form id="form-image-deleted" method="POST">
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
    //image
    //===================================================================
    //Delete image
    function deleteImage(id) {
        $('#modal-image-deleted').modal('show');
        $('#form-image-deleted').on('submit', function(e) {
            e.preventDefault();
            path = "images/" + id; //set up path
            $.ajax({
                type: "POST",
                url: path,
                data: $('#form-image-deleted').serialize(),
                success: function(reponse) {
                    $('#modal-image-deleted').modal('hide');
                    alert("Sended sever");
                    location.reload(true);
                },
                error: function(error) {
                    alert("Not send");
                    $('#modal-image-deleted').modal('hide');
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
            data: $('#form-image').serialize(),
            success: function(reponse) {
                $('#modal-image').modal('hide');
                alert("Sended sever");
                location.reload(true);
            },
            error: function(error) {
                alert("Not send");
                $('#modal-image').modal('hide');
                console.log(error);
            }
        });
    }
</script>
@endsection
