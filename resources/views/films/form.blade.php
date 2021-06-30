@section('content')
    <div class="card mt-5 from-red-500">
        <div class="card-header">{{ __('Film') }}</div>
        <div class="card-body">
            @include('partials.errors')
            @extends('layouts.app')
            {{-- start form --}}
            <form action="{{ isset($film) ? route('films.update', $film->id) : route('films.store') }}" id="form-film"
                method="POST" enctype="multipart/form-data">
                @csrf
                @isset($film)
                    @method("PUT")
                @endisset
                {{-- fields --}}
                <div class="form-group">
                    <label for="name" class="tw-text-red-300">Name</label>
                    <input value="{{ isset($film) ? $film->name : '' }}" type="text" class="form-control" name="name"
                        id="name" placeholder="Jon Snow">
                </div>
                <div class="form-group">
                    <label for="name">Original name</label>
                    <input value="{{ isset($film) ? $film->original_name : '' }}" type="text" class="form-control"
                        name="original_name" id="original_name" placeholder="Jon Snow">
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <textarea name="status" id="status" class="form-control" cols="3"
                        rows="2">{{ isset($film) ? $film->status : '' }}</textarea>
                    {{-- <trix-editor input="status"></trix-editor> --}}
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control" cols="3"
                        rows="2">{{ isset($film) ? $film->description : '' }}</textarea>
                </div>

                <div class="form-group">
                    <label for="director">director</label>
                    <input value="{{ isset($film) ? $film->director : '' }}" type="text" class="form-control"
                        name="director" id="director" placeholder="Jon Snow">
                </div>
                <div class="form-group">
                    <label for="actor">Actor</label>
                    <input value="{{ isset($film) ? $film->actor : '' }}" type="text" class="form-control" name="actor"
                        id="actor" placeholder="Jon Snow">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="type">type</label>
                        <select name="type_id" id="type_id" class="form-control  type-controller">
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}" @if (isset($film) && $film->hasType($type->id)) selected @endif>
                                    {{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="views">Views</label>
                        <input value="{{ isset($film) ? $film->views : '' }}" type="number" min="0" class="form-control"
                            name="views" id="views">
                    </div>
                </div>
                <div class="form-group">
                    <label for="categories">Categories</label>
                    <br>

                    <select name="categories[]" id="categories" class="form-control  categories-controller" multiple>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if (isset($film) && $film->hasCategories($category->id)) selected @endif>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="nation">Nation</label>
                    <br>
                    <select name="nation_id" id="nation_id" class="form-control  nation-controller">
                        @foreach ($nations as $nation)
                            <option value="{{ $nation->id }}" @if (isset($film) && $film->hasNation($nation->id)) selected @endif>
                                {{ $nation->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="image">Choose file</label><br>
                        <input type="file" class="form-control" name="image" id="image" accept="image/*"
                            onchange="document.getElementById('display').src =  window.URL.createObjectURL(this.files[0])"
                            value="{{ isset($film) ? $film->image : '' }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="imdb">IMDB</label>
                        <input value="{{ isset($film) ? $film->imdb : '' }}" type="number" step="0.1" min="0" max="10"
                            class="form-control" name="imdb" id="imdb">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="published">Published At</label><br>
                        <input type="text" class="form-control" name="published" id="published"
                            value="{{ isset($film) ? $film->published : '' }}">
                    </div>
                </div>
                <div class="form-group">
                    <img src="{{ isset($film) ? url('storage/' . $film->image) : '' }}" class="img-fluid" alt=""
                        id="display">
                </div>
                {{-- end flied --}}
                {{-- button --}}
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                {{-- end button --}}
            </form>
            {{-- end form --}}
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        flatpickr('#published', {
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
