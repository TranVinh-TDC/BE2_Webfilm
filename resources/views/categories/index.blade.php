@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-end mb-2">
        <div class="d-flex" style="padding-right:150px">
            <form class="form-inline my-2 my-lg-0" action="{{ route('search.categories') }}" method="GET">
                <input class="form-control mr-sm-2" id="search" name="search" type="text" placeholder="Search"
                    value="{{ request()->query('search') }}">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
        <div class="btn btn-success float-right " data-toggle="modal" onclick="addCategory()">
            Add Category
        </div>
    </div>
    <div class="card card-default">
        @include('partials.errors')
        <div class="card-header">Categories</div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <th>Name</th>
                    <th>Films Count</th>
                    <th></th>
                </thead>
                <tbody>

                    @forelse ($categories as $category)
                        <tr>
                            <td>
                                {{ $category->name }}
                            </td>
                            <td>
                                {{ $category->films->count() }}
                            </td>
                            <td>
                                <div class="btn btn-primary  btn-sm float-right" data-toggle="modal"
                                    onclick="deleteCategory({{ $category->id }})">
                                    Delete
                                </div>
                                <div class="btn btn-danger mr-2 btn-sm float-right" data-toggle="modal"
                                    onclick="updateCategory({{ $category->id }})">
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
                  {{ $categories->appends(['search' => request()->query('search')])->links() }}

        </div>
    </div>
    <!-- Modal update vs create -->
    <div class="modal fade" id="modal-category" tabindex="-1" role="dialog" aria-labelledby="modal-category"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Add Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- start form --}}
                    <form id="form-category" method="POST">
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
    <div class="modal fade" id="modal-category-deleted" tabindex="-1" role="dialog" aria-labelledby="modal-category-deleted"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Delete Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- start form --}}
                    <h4 class="text-center">Are you deleting this category ?</h4>
                    <form id="form-category-deleted" method="POST">
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
    //Category
    //===================================================================
    // Add category
    function addCategory() {
        $('#modal-category').modal('show');
        $('#form-category').on('submit', function(e) {
            e.preventDefault()
            path = "{{ route('categories.store') }}"; //set up path
            ajax(path);
        });
    }
    //Update category
    function updateCategory(id) {
        let path = "categories/" + id + "/edit";
        //get val
        $.get(path, function(category) {
            //set fileds
            $('#name').val(category.name);
        })
        //modal vs ajax
        $('#modal-category').modal('show');
        $('#form-category').on('submit', function(e) {
            e.preventDefault()

            path = "categories/" + id; //set up path
            $('#_method').val("PUT"); // set up method

            ajax(path);
        });
    }
    //Delete category
    function deleteCategory(id) {
        $('#modal-category-deleted').modal('show');
        $('#form-category-deleted').on('submit', function(e) {
            e.preventDefault();
            path = "categories/" + id; //set up path
            $.ajax({
                type: "POST",
                url: path,
                data: $('#form-category-deleted').serialize(),
                success: function(reponse) {
                    $('#modal-category-deleted').modal('hide');
                    alert("Sended sever");
                    location.reload(true);
                },
                error: function(error) {
                    alert("Not send");
                    $('#modal-category-deleted').modal('hide');
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
            data: $('#form-category').serialize(),
            success: function(reponse) {
                $('#modal-category').modal('hide');
                alert("Sended sever");
                location.reload(true);
            },
            error: function(error) {
                alert("Not send");
                $('#modal-category').modal('hide');
                console.log(error);
            }
        });
    }
</script>
@endsection
