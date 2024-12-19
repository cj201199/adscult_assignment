@extends('layout')



@section('content')
    <div class="container">
        <div class="row justify-content-center" style="margin-top: 30px">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>
                    <div class="card-body">
                        <div class="d-flex my-4 justify-content-between">
                            <div class="table-search">
                            </div>
                            <a href="{{ route('review-add') }}" class="save-btn">
                                <img src="{{ asset('public/src//assets//img/sai_img/plus-circle.svg') }}" class="me-2"
                                    alt="">
                                Add Review</a>
                        </div>
                        <table id="example" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Book Name</th>
                                    <th>user</th>
                                    <th>Review</th>
                                    <th>Rating</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($books as $data)
                                    @if ($data && $data->reviews->isNotEmpty())
                                        @foreach ($data->reviews as $review)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->title }}</td>
                                                <td>{{ $review->user->name ?? 'N/A' }}</td>
                                                <td>{{ $review->review ?? 'N/A' }}</td>
                                                <td>{{ $review->rating ?? 'N/A' }} Stars</td>
                                                <td class="text-center table-action">
                                                    @if ($review->user_id == Auth::user()->id)
                                                        <div class="table-view-btn d-inline-flex align-items-center gap-2">
                                                            <a href="{{ route('review-edit', $review->id) }}"
                                                                class="datatable-icons for-eye-bg bs-tooltip"
                                                                title="Edit">
                                                                <i class="fas fa-edit text-primary"></i>
                                                            </a>
                                                            <a class="datatable-icons for-eye-bg bs-tooltip review-delete"
                                                                title="Delete" data-delete="{{ $review->id }}"
                                                                data-bs-toggle="modal" data-bs-target="#specDel">
                                                                <i class="fas fa-trash-alt text-danger"></i>
                                                            </a>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade check-modal" id="specDel" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3 justify-content-center">
                        <div class="col-md-8">
                            <div class="text-center">
                                <img src="{{ asset('public/src/assets/img/sai_img/trash-red.svg') }}" alt="">
                                <p class="p_dark" style="font-size:20px;">Are You Sure?</p>
                                <p class="para-norm">Are you sure you want to delete this record?</p>
                            </div>
                        </div>
                    </div>
                    <div class="double-btn mt-2">
                        {{-- <button class="cancel-btn">Cancel</button> --}}
                        <button class="save-btn" type="submit" id="review_delete_form"
                            style="background-color: #fabbbd;color:#ED1B24;">Delete</button>
                    </div>
                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                lengthChange: true,
            });
        });


        $(document).ready(function() {
            let deleteId;

            $(document).on('click', '.review-delete', function() {
                deleteId = $(this).data('delete');
            });

            $('#review_delete_form').on('click', function() {
                if (deleteId) {
                    $.ajax({
                        url: 'review-delete-form/' + deleteId,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function(response) {
                            if (response.status === 200) {
                                toastr.success(response.message);
                                setTimeout(function() {
                                    window.location.reload();
                                }, 2000);
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function(xhr) {
                            toastr.error('Failed to delete the record. Please try again.');
                        },
                    });
                }
            });
        });
    </script>
@endsection
