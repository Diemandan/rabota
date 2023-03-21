@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Solution</h1>
        <form action="#" method="POST">
            @csrf

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                    value="{{ old('title') }}">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mt-2">
                <label for="description">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>



            <div class="form-group mt-2">
                <label for="search-keyword">Add keyword</label>
                <input type="text" class="form-control" id="search-keyword" name="search-keyword"
                    value="{{ old('search-keyword') }}">
            </div>

            <button type="submit" class="btn btn-primary mt-2">Create</button>
        </form>

        <br>
        <a href="#" class="btn btn-primary mb-3">Back</a>
    </div>

    <script type="text/javascript">
        var path = "{{ url('/keywords/search') }}";

        $("#search-keyword").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: path,
                    type: 'GET',
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            }
        });
    </script>

    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
