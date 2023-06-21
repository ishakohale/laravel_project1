@extends('layout')

@section('content')

    <style>
        .button-link {
            color: aliceblue;
        }
    </style>

    <h2 class="text-center">Library Management System</h2>
    <hr>

    <!-- Button trigger modal -->
    <div class="text-center">
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#addStudentModal">
            Issue Book
        </button>
        <a href="{{ url('books') }}"class="button-link">
        <button type="button" class="btn btn-secondary ">
         Books
        </button></a>
        <a href="{{ url('students') }}" class="button-link">
            <button type="button" class="btn btn-secondary">

                Student </button>
        </a>
    </div>

    <hr>

    <table id="studentsTable" class="table">
        <thead>
            <th>Id</th>
            <th>StudentName</th>
            <th>BookName</th>
            <th>Date</th>
            <th>Action</th>
        </thead>
        <tbody>
        </tbody>
    </table>

    <!-- Add student modal -->
    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form id="addStudentForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Issued Book</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>




                    <div class="modal-body">
                        <label for="cars">Select Student:</label>

                        {{-- @foreach ($student as $stud ) --}}
                        {{-- {{ dd($stud->name) }} --}}
                        {{-- @endforeach --}}
                        <select name="student" id="student">
                            <option value="">select</option>
                            @foreach ($student as $stud )
                            <option value={{ $stud->id }}>{{ $stud->name }}</option>
                            @endforeach


                        </select>
                    </div>
                    <div class="modal-body">
                        <label for="books">Select Book:</label>
                        {{-- {{ dd($book) }} --}}
                        <select name="bookname" id="book">
                            <option value="">select</option>
                            @foreach ($book as $bo )
                            <option value={{ $bo->id }}>{{ $bo->bookname }}</option>
                            @endforeach


                        </select>
                    </div>
                    <br>
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancle</button>
                        <button type="submit" class="btn btn-primary">Issue </button>
                    </div>
            </div>
            </form>

        </div>
    </div>




@section('scripts')
<script>


    $(document).ready(function() {

        // datatable initialization
        var table = $('#studentsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{url('/home')}}",
                type: 'GET',
            },
            columns: [{
                    data: 'id',
                    name: 'id',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'student_id',
                    name: 'student_id',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'book_id',
                    name: 'book_id',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'Date',
                    name: 'Date',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
        });


    });


    // on submit add student form

    $('#addStudentForm').submit(function(event) {
        // Prevent the form from submitting
        event.preventDefault();

        // get form data
        var formData = new FormData(this);
        var formDataObj = {};
        for (var pair of formData.entries()) {
            formDataObj[pair[0]] = pair[1];
        }

        // set action url
        var action = "{{url('home/store')}}";

        // make ajax request
        $.ajax({
            type: "POST",
            url: action,
            data: formDataObj,

            success: function(response) {
                $('#addStudentModal').modal('hide');

                if (response.success == true) {
                    swal({
                        title: "Success",
                        text: response.message,
                        icon: "success",
                        timer: 4000,
                        buttons: [false, "Ok"]
                    }).then((result) => {

                        $('#studentsTable').DataTable().draw(true);
                    });
                } else {
                    swal({
                        title: "Error",
                        text: response.message,
                        icon: "error",
                        timer: 4000
                    });
                }
            },
            error: function(response) {
                swal({
                    title: "Error",
                    text: 'Something went wrong',
                    icon: "error",
                    timer: 5000
                });
            }
        }).fail(function() {
            swal({
                title: "Error",
                text: 'Something went wrong',
                icon: "error",
                timer: 5000
            });
        });
    });


    // delete student record )(event listner)
    $('body').on('click', '.delete', function() {

// get id of record
deleteID = $(this).data('id');

swal({
    title: 'Delete',
    text: "Are you sure want to delete this entry?",
    icon: 'warning',
    buttons: [true, "Yes Delete"],

}).then(function(result) {
    if (result) {

        var action = "{{url('home/destroy')}}";
        var token = '<?php echo csrf_token(); ?>';
        // make ajax request to delete
        $.ajax({
            type: "POST",
            url: action,
            data: {
                "id": deleteID,
                "_token": token
            },

            success: function(response) {

                if (response.success) {
                    swal({
                        title: "Success",
                        text: response.message,
                        icon: "success",
                        timer: 4000,
                        buttons: [false, "Ok"]
                    }).then((result) => {

                        $('#studentsTable').DataTable().draw(false);
                    });
                } else {
                    swal({
                        title: "Error",
                        text: response.message,
                        icon: "error",
                        timer: 4000
                    });
                }
            },
            error: function(response) {
                swal({
                    title: "Error",
                    text: 'Something went wrong',
                    icon: "error",
                    timer: 5000
                });
            }
        }).fail(function() {
            swal({
                title: "Error",
                text: 'Something went wrong',
                icon: "error",
                timer: 5000
            });
        });

    }
});
});
</script>
@endsection
