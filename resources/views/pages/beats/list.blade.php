<x-layout :currentPage="$currentPage">
    <div class="mt-2 mb-2">
        <button
        class="btn btn-primary"
        onclick="showCreateForm()"
    >
        Add New
    </button>


    </div>    
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body tablecontainer">
                        <h5 class="card-title">Beats List</h5>
                        <!-- Table with stripped rows -->
                        <table class="table mt-1">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @include('pages.beats.single',['beats'=>$beats])
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('pages.beats.modal')

    <script>



        function showEditForm(beat, edit_url) {
            $("#edit_url").val("");
            $("#beat_form")[0].reset();
            let beatJson = JSON.parse(beat);

            $("#modal-title").html("Edit Beat");
            $("#edit_url").val(edit_url);
            $("#beat_name").val(beatJson.beat_name);
            $("#beat_address").val(beatJson.beat_address);
            if (beatJson.is_active == 1) {
                $("#beat_active").prop("checked", true);
            } else {
                $("#beat_active").prop("checked", false);
            }
            $("#beatModal").modal("show");
        }

        function showCreateForm() {
            $("#edit_url").val("");
            $("#beat_form")[0].reset();

            $("#modal-title").html("Create Beat");
            $("#beatModal").modal("show");
        }

        function submitBeatForm() {
            let form = $("#beat_form").serializeArray();

            let isEdit = $("#edit_url").val();
            let url = $("#store_url").val();
            if (isEdit.length > 0) {
                url = $("#edit_url").val();
            }

            let data = {
                beat_name: form.find((item) => item.name === "beat_name").value,
                beat_address: form.find((item) => item.name === "beat_address")
                    .value,
                is_active: $("#beat_active").prop("checked") ? 1 : 0,
            };

            $.ajax({
                url: url, // The URL defined in your routes
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ), // CSRF Token
                },
                dataType: "json",
                data: data,
                success: function (response) {
                    if (response.success) {
                        alert(response.message);
                        location.reload();
                    } else if (!response.success) {
                        alert(response.message);
                    }
                },
                error: function (xhr, status, error) {
                    alert(error);
                },
            });
        }

        function showDeleteConfirmationDialog(id, url) {
            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to delete this Beat? This will delete all customers associated with this Beat",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: "No",
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, proceed with AJAX request to delete the resource
                    $.ajax({
                        url: url, // Your route to delete the resource
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}", // CSRF token for security
                        },
                        success: function (response) {
                            Swal.fire("Deleted!", response.message, "success");
                            location.reload();
                        },
                        error: function (xhr, status, error) {
                            Swal.fire(
                                "Error!",
                                "There was an issue deleting the resource.",
                                "error"
                            );
                        },
                    });
                } else {
                    // If the user canceled, do nothing
                }
            });
        }
    </script>
</x-layout>
