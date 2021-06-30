@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-end mb-2">
        <div class="d-flex" style="padding-right:150px">
            <form class="form-inline my-2 my-lg-0" action="{{ route('search.links') }}" method="GET">
                <input class="form-control mr-sm-2" id="search" name="search" type="text" placeholder="Search"
                    value="{{ request()->query('search') }}">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
        <div class="btn btn-success float-right " data-toggle="modal" onclick="addlink()">
            Add link
        </div>
    </div>
    <div class="card card-default">
        @include('partials.errors')
        <div class="card-header">links</div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <th>Name</th>
                    <th>Film name</th>
                    <th></th>
                </thead>
                <tbody>
                    @forelse ($links as $link)
                        <tr>
                            <td>
                                {{ $link->name }}
                            </td>
                            <td>
                                {{ $link->films->original_name }}
                            </td>
                            <td>
                                <div class="btn btn-primary  btn-sm float-right" data-toggle="modal"
                                    onclick="deleteLink({{ $link->id }})">
                                    Delete
                                </div>
                                <div class="btn btn-danger mr-2 btn-sm float-right" data-toggle="modal"
                                    onclick="updateLink({{ $link->id }})">
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
            {{ $links->appends(['search' => request()->query('search')])->links() }}

        </div>
    </div>
    <!-- Modal update vs create -->
    <div class="modal fade" id="modal-link" tabindex="-1" role="dialog" aria-labelledby="modal-link" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Add link</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- start form --}}
                    <form id="form-link" method="POST">
                        {{-- fields --}}
                        @csrf
                        <input type="hidden" id="_method" name="_method" value="">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="">
                        </div>
                        <div class="form-group">
                            <label for="name">Film</label>
                            <select name="film_id" id="film_id" class="form-control  film-controller">
                                @foreach ($films as $film)
                                    <option id="{{ $film->id }}" value="{{ $film->id }}" }}>
                                        {{ $film->original_name }}</option>
                                @endforeach
                            </select>
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
    <div class="modal fade" id="modal-link-deleted" tabindex="-1" role="dialog" aria-labelledby="modal-link-deleted"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Delete link</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- start form --}}
                    <h4 class="text-center">Are you deleting this link ?</h4>
                    <form id="form-link-deleted" method="POST">
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
    //link
    //===================================================================
    // Add link
    function addlink() {
        //set default value = ""
        $('#name').val("https://www.youtube.com/embed/");
        $("#film_id").val("");

        $('#modal-link').modal('show');
        $('#form-link').on('submit', function(e) {
            e.preventDefault()
            path = "{{ route('links.store') }}"; //set up path
            ajax(path);
        });
    }
    //Update link
    function updateLink(id) {
        let path = "links/" + id + "/edit";
        //get val
        $.get(path, function(link) {
            //set fileds
            $('#name').val(link.name);
            $("#film_id").val(link.film_id);
        })
        //modal vs ajax
        $('#modal-link').modal('show');
        $('#form-link').on('submit', function(e) {
            e.preventDefault()
            path = "links/" + id; //set up path
            $('#_method').val("PUT"); // set up method


            ajax(path);
        });
    }
    //Delete link
    function deleteLink(id) {
        $('#modal-link-deleted').modal('show');
        $('#form-link-deleted').on('submit', function(e) {
            e.preventDefault();
            path = "links/" + id; //set up path
            $.ajax({
                type: "POST",
                url: path,
                data: $('#form-link-deleted').serialize(),
                success: function(reponse) {
                    $('#modal-link-deleted').modal('hide');
                    alert("Sended sever");
                    location.reload(true);
                },
                error: function(error) {
                    alert("Not send");
                    $('#modal-link-deleted').modal('hide');
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
            data: $('#form-link').serialize(),
            success: function(reponse) {
                $('#modal-link').modal('hide');
                alert("Sended sever");
                location.reload(true);
            },
            error: function(error) {
                alert("Not send");
                $('#modal-link').modal('hide');
                console.log(error);
            }
        });
    }
</script>
@endsection
