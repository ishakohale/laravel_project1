


<div class="modal-dialog">
    <div class="modal-content">

        <form id="editStudentForm">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Student</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="id" value="{{$data->id}}">
                <label for="name">name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{$data->name}}">

                <label for="city">city</label>
                <input type="text" name="city" id="city" class="form-control" value="{{$data->city}}">

                <label for="contact">contact</label>
                <input type="number" name="contact" id="contact" class="form-control" value="{{$data->contact}}">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save </button>
            </div>
    </div>
    </form>

</div>

<script>
    $(document).ready(function() {
        // on submit edit student form

        $('#editStudentForm').submit(function(event) {
            // Prevent the form from submitting
            event.preventDefault();

            // get form data
            var formData = new FormData(this);
            var formDataObj = {};
            for (var pair of formData.entries()) {
                formDataObj[pair[0]] = pair[1];
            }

            // set action url
            var action = "{{url('students/update')}}";

            // make ajax request
            $.ajax({
                type: "POST",
                url: action,
                data: formDataObj,

                success: function(response) {

                    $('#editStudentModal').modal('hide');

                    if (response.success == true) {
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
        });
    })
</script>
