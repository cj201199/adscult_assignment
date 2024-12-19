@extends('layout')



@section('content')
    <div class="container">
        <div class="row justify-content-center" style="margin-top: 30px">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>
                    <div class="card-body">
                        <form id="reviewaddform">
                            <div class="form-group">
                                <label for="books">Books</label>
                                <select class="form-control" name="books" id="exampleFormControlSelect1">
                                    <option disabled selected>Select Books</option>
                                    @foreach ($books as $data)
                                        <option value="{{ $data->id }}">{{ $data->author }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="rating">Rating</label>
                                <input type="number" name="rating" min="1" max="5" class="form-control"
                                    id="exampleInputEmail1" placeholder="Enter rating">
                            </div>
                            <div class="form-group">
                                <label for="Review">Review</label>
                                <textarea id="review" name="review" placeholder="Enter Review" class="form-control"></textarea>
                            </div>
                            <button type="submit" id="reviewaddbtn" class="btn btn-primary">Submit</button>
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
            $('#reviewaddbtn').on('click', function() {
                $('#reviewaddform').validate({
                    rules: {
                        books: {
                            required: true,
                        },
                        rating: {
                            required: true,
                        },
                        review: {
                            required: true,
                        }
                    },
                    messages: {
                        books: {
                            required: "Please select books",
                        },
                        rating: {
                            required: "Please enter rating",
                        },
                        review: {
                            required: "Please enter review",
                        }
                    },
                    submitHandler: function(form) {
                        var formData = new FormData(form);
                        var $btn = $('#reviewaddbtn');
                        $btn.prop('disabled', true).text('Processing...');

                        $.ajax({
                            url: "add-review",
                            type: "POST",
                            data: formData,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                if (response.status === 200) {
                                    toastr.success(response.message);
                                    setTimeout(function() {
                                            window.location.href = "dashboard";
                                        },
                                        1000);
                                } else {
                                    toastr.error(response.message);
                                }
                                $btn.prop('disabled', false).text('submit');
                            },
                            error: function(xhr) {
                                toastr.error(
                                    "Something went wrong. Please try again.");
                                $btn.prop('disabled', false).text('submit');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection