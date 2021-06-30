@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-end mb-2">
        <div class="d-flex" style="padding-right:150px">
            <form class="form-inline my-2 my-lg-0" action="{{ route('search.nations') }}" method="GET">
                <input class="form-control mr-sm-2" id="search" name="search" type="text" placeholder="Search"
                    value="{{ request()->query('search') }}">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
        <div class="btn btn-success float-right " data-toggle="modal" onclick="addNation()">
            Add nation
        </div>
    </div>
    <div class="card card-default">
        @include('partials.errors')
        <div class="card-header">nations</div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <th>Name</th>
                    <th>Films Count</th>
                    <th></th>
                </thead>
                <tbody>
                    @forelse ($nations as $nation)
                        <tr>
                            <td>
                                {{ $nation->name }}
                            </td>

                            <td>
                                @if ($nation->films)
                                    {{ $nation->films->count() }}
                                @endif
                            </td>
                            <td>
                                <div class="btn btn-primary  btn-sm float-right" data-toggle="modal"
                                    onclick="deleteNation({{ $nation->id }})">
                                    Delete
                                </div>
                                <div class="btn btn-danger mr-2 btn-sm float-right" data-toggle="modal"
                                    onclick="updateNation({{ $nation->id }})">
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

            {{ $nations->appends(['search' => request()->query('search')])->links() }}

        </div>
    </div>
    <!-- Modal update vs create -->
    <div class="modal fade" id="modal-nation" tabindex="-1" role="dialog" aria-labelledby="modal-nation" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Add nation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- start form --}}
                    <form id="form-nation" method="POST">
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
    <div class="modal fade" id="modal-nation-deleted" tabindex="-1" role="dialog" aria-labelledby="modal-nation-deleted"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Delete nation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- start form --}}
                    <h4 class="text-center">Are you deleting this nation ?</h4>
                    <form id="form-nation-deleted" method="POST">
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
    //nation
    //===================================================================
    // Add nation
    function addNation() {
        $('#modal-nation').modal('show');
        $('#form-nation').on('submit', function(e) {
            e.preventDefault()
            path = "{{ route('nations.store') }}"; //set up path
            ajax(path);
        });
    }
    //Update nation
    function updateNation(id) {
        let path = "nations/" + id + "/edit";
        //get val
        $.get(path, function(nation) {
            //set fileds
            $('#name').val(nation.name);
        })
        //modal vs ajax
        $('#modal-nation').modal('show');
        $('#form-nation').on('submit', function(e) {
            e.preventDefault()

            path = "nations/" + id; //set up path
            $('#_method').val("PUT"); // set up method

            ajax(path);
        });
    }
    //Delete nation
    function deleteNation(id) {
        $('#modal-nation-deleted').modal('show');
        $('#form-nation-deleted').on('submit', function(e) {
            e.preventDefault();
            path = "nations/" + id; //set up path
            $.ajax({
                type: "POST",
                url: path,
                data: $('#form-nation-deleted').serialize(),
                success: function(reponse) {
                    $('#modal-nation-deleted').modal('hide');
                    alert("Sended sever");
                    location.reload(true);
                },
                error: function(error) {
                    alert("Not send");
                    $('#modal-nation-deleted').modal('hide');
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
            data: $('#form-nation').serialize(),
            success: function(reponse) {
                $('#modal-nation').modal('hide');
                alert("Sended sever");
                location.reload(true);
            },
            error: function(error) {
                alert("Not send");
                $('#modal-nation').modal('hide');
                console.log(error);
            }
        });
    }
</script>
@endsection
