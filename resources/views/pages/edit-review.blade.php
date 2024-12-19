@extends('layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center" style="margin-top: 30px">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Review</div>
                    <div class="card-body">
                        <form id="revieweditform">
                            <div class="form-group">
                                <label for="books">Books</label>
                                <select class="form-control" name="books" id="exampleFormControlSelect1">
                                    <option disabled selected>Select Books</option>
                                    @foreach ($books as $data)
                                        <option
                                            value="{{ $data->id }}"{{ $review->book_id == $data->id ? 'selected' : '' }}>
                                            {{ $data->author }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="rating">Rating</label>
                                <input type="number" class="form-control" min="1" max="5" name="rating"
                                    id="rating" value="{{ $review->rating }}" placeholder="Enter rating">
                                <input type="hidden" class="form-control" name="rating_id" value="{{ $review->id }}">
                            </div>
                            <div class="form-group">
                                <label for="review">Review</label>
                                <textarea id="review" name="review" placeholder="Enter Review" class="form-control">{{ $review->review }}</textarea>
                            </div>
                            <button type="submit" id="revieweditbtn" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#revieweditbtn').on('click', function() {
                $('#revieweditform').validate({
                    rules: {
                        books: {
                            required: true,
                        },
                        rating: {
                            required: true,
                            min: 1,
                            max: 5,
                        },
                        review: {
                            required: true,
                        },
                    },
                    messages: {
                        books: {
                            required: "Please select books",
                        },
                        rating: {
                            required: "Please enter rating",
                            min: "Rating must be at least 1",
                            max: "Rating must not exceed 5",
                        },
                        review: {
                            required: "Please enter review",
                        },
                    },
                    submitHandler: function(form) {
                        var formData = new FormData($('#revieweditform')[0]);
                        var $btn = $('#revieweditbtn');
                        $btn.prop('disabled', true).text('Processing...');

                        $.ajax({
                            url: "{{ route('update-review') }}",
                            type: "POST",
                            data: formData,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content'),
                            },
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                if (response.status === 200) {
                                    toastr.success(response.message);
                                    setTimeout(function() {
                                        window.location.href = "{{ route('dashboard') }}";
                                    }, 1000);
                                } else if (response.status === 401) {
                                    toastr.error(response.message);
                                } else {
                                    toastr.error(response.message);
                                }
                                $btn.prop('disabled', false).text('Submit');
                            },
                            error: function(xhr) {
                                toastr.error(
                                    "Something went wrong. Please try again.");
                                $btn.prop('disabled', false).text('Submit');
                            },
                        });
                    },
                });
            });
        });
    </script>
@endsection
