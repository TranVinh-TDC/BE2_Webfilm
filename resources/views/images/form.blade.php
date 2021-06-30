@section('content')
    <div class="card mt-5 from-red-500">
        <div class="card-header">{{ __('Image') }}</div>
        <div class="card-body">
            @include('partials.errors')
            @extends('layouts.app')
            {{-- start form --}}
            {{-- start form --}}
            <form action="{{isset($image) ? route('images.update', $image->id) : route('images.store')}}" id="form-cast" method="POST" enctype="multipart/form-data">
                {{-- fields --}}
                @csrf
                @isset($image)
                    @method('PUT')
                @endisset
                <div class="form-group">
                    <label for="film_id">Film</label>
                    <br>
                    <select name="film_id" id="film_id" class="form-control  film-controller">
                        @foreach ($films as $film)
                            <option value="{{ $film->id }}" {{ isset($image) && $image->hasFilm($film->id) ? "seleted" : ""}}>
                                {{ $film->original_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="fimage">image</label>
                    <input type="file" class="form-control" name="image" id="image" accept="image/*"
                    onchange="document.getElementById('display').src =  window.URL.createObjectURL(this.files[0])"
                    value="{{isset($image) ? $image->image : ''}}">
                </div>
                <div class="form-group">
                    <img src="{{ isset($image) ? url('storage/' . $image->image) : '' }}" class="img-fluid mx-auto d-flex justify-content-center flex-wrap" alt=""
                        id="display">
                </div>
                {{-- end flied --}}
                {{-- button --}}
                <div class="modal-footer">
                    <button type="submit" id="button-form" class="btn btn-primary">Save changes</button>
                </div>
                {{-- end button --}}
            </form>
            {{-- end form --}}
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
