@extends('layout')

@section('content')
<h2 class="text-center">Student Who issued book</h2>
<hr>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addStudentModal">
    Add New Student
</button>

<button type="button" style="float:right" onclick="backButton()" >
    back
  </button>
<hr>

<table id="studentsTable" class="table">
    <thead>
        <th>Id</th>
        <th>StudentName</th>
        <th>City</th>
        <th>Contact</th>
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
                    <h5 class="modal-title" id="addModalLabel">Add New Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <label for="name">name</label>
                    <input type="text" name="name" id="name" class="form-control">

                    <label for="city">city</label>
                    <input type="text" name="city" id="city" class="form-control">

                    <label for="contact">contact</label>
                    <input type="number" name="contact" id="contact" class="form-control">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save </button>
                </div>
        </div>
        </form>

    </div>
</div>

<!-- edit student modal -->
<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

</div>
@endsection

@section('scripts')

<style>
    button{
        background-color:grey;
        font-size:20px;
        color:white;
    }

</style>


<script>


function backButton() {

    window.history.back();

    }

    $(document).ready(function() {

        // datatable initialization
        var table = $('#studentsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{url('/students')}}",
                type: 'GET',
            },
            columns: [{
                    data: 'id',
                    name: 'id',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'name',
                    name: 'name',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'city',
                    name: 'city',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'contact',
                    name: 'contact',
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
        var action = "{{url('students/store')}}";

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

                var action = "{{url('students/destroy')}}";
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

    // edit student modal
    $('body').on('click', '.edit', function() {

        editID = $(this).data('id');
        var action = "{{url('students/edit')}}/" + editID;
        // make ajax request to delete
        $.ajax({
            type: "GET",
            url: action,

            success: function(response) {

                if (response.success) {
                    $("#editStudentModal").html(response.html);
                    $("#editStudentModal").modal('show');
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
</script>
@endsection
