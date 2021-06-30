@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-end mb-2">
        <div class="d-flex" style="padding-right:150px">
            <form class="form-inline my-2 my-lg-0" action="{{ route('search.films') }}" method="GET">
                <input class="form-control mr-sm-2" id="search" name="search" type="text" placeholder="Search"
                    value="{{ request()->query('search') }}">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
        <a href="{{ route('films.create') }}"
            class="btn btn-success float-right tw-bg-gradient-to-r tw-from-green-400 tw-to-blue-500 tw-hover:from-pink-500 tw-hover:to-yellow-500">
            Add Film
        </a>
    </div>
    <div class="card card-default">
        @include('partials.errors')
        <div class="card-header">
            <div class="p-2"> Films</div>
        </div>
        <div class="card-body">
            @if ($films->count() > 0)
                <table class="table">
                    <thead>
                        <th>Image</th>
                        <th>Name</th>
                        <th>imdb</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @forelse($films as $film)
                            <tr>
                                <td>
                                    ​<picture>
                                        <source srcset="{{ url('storage/' . $film->image) }}" type="image/svg+xml">
                                        <img src="{{ url('storage/' . $film->image) }}" width="70px"
                                            class="img-fluid img-thumbnail mx-auto"
                                            alt="{{ url('storage/' . $film->image) }} ">
                                    </picture>
                                </td>
                                <td>
                                    {{ $film->original_name }}
                                </td>
                                <td>
                                    {{ $film->imdb }}
                                </td>
                                <td>
                                    <div class="btn btn-danger btn-sm float-right" data-toggle="modal"
                                        onclick="deleteFilm({{ $film->id }})">
                                        {{ $film->trashed() ? 'Delete' : 'Trash' }}
                                    </div>
                                    @if ($film->trashed())
                                        <form class=" float-right" method="POST"
                                            action="{{ route('films.restore', $film->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-primary btn-sm mr-1 " data-toggle="modal">
                                                Restore
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('films.edit', $film->id) }}"
                                            class="btn btn-primary btn-sm mr-2 float-right ">
                                            Edit
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <p class="text-center"> No results found for query
                                <strong>{{ request()->query('search') }}</strong>
                            </p>
                        @endforelse
                    </tbody>

                </table>
                {{ $films->appends(['search' => request()->query('search')])->links() }}
            @else
                <h5 class="text-center">Films not yet</h5>
            @endif
        </div>
    </div>

    {{-- Modal delete --}}
    <div class="modal fade" id="modal-film-deleted" tabindex="-1" role="dialog" aria-labelledby="modal-film-deleted"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Delete film</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- start form --}}
                    <h3 class="text-center tw-text-2xl">Are you deleting this film ?</h3>
                    <form id="form-film-deleted" method="POST">
                        {{-- fields --}}
                        @csrf
                        @method("DELETE")
                        {{-- end flied --}}
                        {{-- button --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" id="button-form" class="btn btn-sm btn-primary">Yes</button>
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

@section('styles')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .select2-container--default .select2-selection--multiple {
        padding-right: 100px;
    }

</style>
@endsection

@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    //==================================================================
    //film
    //===================================================================
    //Delete film
    function deleteFilm(id) {
        $('#modal-film-deleted').modal('show');
        $('#form-film-deleted').on('submit', function(e) {
            e.preventDefault();
            path = "films/" + id; //set up path
            $.ajax({
                type: "POST",
                url: path,
                data: $('#form-film-deleted').serialize(),
                success: function(reponse) {
                    $('#modal-film-deleted').modal('hide');
                    alert("Sended sever");
                    location.reload(true);
                },
                error: function(error) {
                    alert("Not send");
                    $('#modal-film-deleted').modal('hide');

                    console.log(error);
                }
            });
        });
    }
    //=================================================================
</script>
<script>
    flatpickr('#published_at', {
        enableTime: true,
        static: true
    });
</script>
<script>
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('.categories-controller').select2();
    });
    var $disabledResults = $(".categories-controller");
    $disabledResults.select2();
</script>
@endsection
