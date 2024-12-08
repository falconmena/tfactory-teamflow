$(document).ready(function () {
    if ($('#team-flow-interaction-dashboard').length) {
        // Init dropzone
        dropzoneInit();
        tinyMceInit();
        getActivityUsers();

        //render logs
        const container = $('#logs-container');
        const type = container.data('type');
        const id = container.data('id');
        const _token = container.data('token');
        const route = container.data('route');

        console.log('Type: ', type);
        console.log('ID: ', id);
        console.log('Route: ', route);

        // Make an AJAX request when the page loads
        $.ajax({
            url: route, // The route URL from the data attribute
            type: 'GET', // or 'POST' based on your route's requirement
            data: {
                type: type,
                id: id
            },
            headers: {
                'X-CSRF-TOKEN': _token // Add CSRF token to the request headers
            },
            success: function (response) {
                // Assuming `response` contains the data you need to render
                console.log(' Logs: ', response);
                // renderLogs(response);
            },
            error: function (xhr, status, error) {
                console.error("An error occurred: ", error);
                alert("Failed to load logs. Please try again later.");
            }
        });

        $('#teamflow_schedule_activity').on('click', function (event) {
            event.preventDefault();

            $('#teamflow-activity-editor-content').val(tinymce.get('teamflow-activity-editor').getContent());

            // Collect form data
            var formData = $('#teamflow_activity_form').serialize();

            // Get the form action URL
            var formAction = $('#teamflow_activity_form').attr('action');

            $.ajax({
                url: formAction,
                type: 'POST',
                data: formData,
                success: function (response) {
                    $('#teamflow_activity_form_response')
                        .html('<strong>Success:</strong> The activity was scheduled successfully!')
                        .addClass('alert alert-success')
                        .show();
                    $('#schedule-activity-modal').modal('hide');
                    $('#teamflow_activity_form')[0].reset();
                },
                error: function (xhr, status, error) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessages = '<div class="alert alert-danger">';

                        // Loop through each error and display it
                        $.each(errors, function (field, messages) {
                            $.each(messages, function (index, message) {
                                errorMessages += '<span class="d-block">' + message + '</span>';
                            });
                        });

                        errorMessages += '</div>';

                        // Display the validation errors
                        $('#teamflow_activity_error_response').html(errorMessages);
                    } else {
                        // Handle other types of errors
                        var errorMessage = xhr.responseJSON.message || 'An error occurred.';
                        $('#teamflow_activity_error_response').html('<p>' + errorMessage + '</p>');
                    }
                }
            });
        });
    }
});

// Attachment Dropzone
const dropzoneInit = () => {
    const dropzoneElement = document.querySelector("#teamflow-data-dropzone-attachment");
    if (dropzoneElement.dropzone) return; // Skip if already initialized

    let attachable_id = document.querySelector('input[name="attachable_id"]').value;
    let attachable_type = document.querySelector('input[name="attachable_type"]').value;
    let created_by = document.querySelector('input[name="created_by"]').value;
    const myDropzone = new Dropzone(dropzoneElement, {
        url: dropzoneElement.action,
        method: "POST",
        paramName: "file",
        autoProcessQueue: false, // Prevent automatic upload
        parallelUploads: 10, // Number of files processed in parallel
        maxFilesize: 20, // Max size in MB
        headers: {
            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
        },
        init: function () {
            const submitButton = document.querySelector("#submit-button");

            submitButton.addEventListener("click", (e) => {
                e.preventDefault();

                if (this.getQueuedFiles().length > 0) {
                    this.processQueue(); // Manually trigger file upload
                } else {
                    alert("No files to upload.");
                }
            });

            this.on("sending", function (file, xhr, formData) {
                // Append additional data to the request
                formData.append("attachable_id", attachable_id);
                formData.append("attachable_type", attachable_type);
                formData.append("created_by", created_by);
            });

            this.on("queuecomplete", function () {
                alert("All files have been uploaded successfully!");
            });

            this.on("error", function (file, errorMessage) {
                alert(`Error uploading file: ${errorMessage}`);
            });
        },
    });

    // Fetch recently uploaded files
    $.ajax({
        type: "GET",
        url: "/teamflow/attachments/recent",
        data: {
            attachable_id,
            attachable_type
        },
        success: function (response) {
            console.log(response);
            response.forEach((file) => {
                const mockFile = { name: file.name, size: file.size };

                // Add the file to Dropzone
                myDropzone.emit("addedfile", mockFile);
                myDropzone.emit("thumbnail", mockFile, file.url); // Set preview image
                myDropzone.emit("complete", mockFile); // Mark file as complete

                // Optional: Set custom properties for future use
                mockFile.previewElement.querySelector(".dz-remove").dataset.fileId = file.id;
            });
        }
    });

    // Handle file removal
    myDropzone.on("removedfile", function (file) {
        // Optional: Perform an AJAX request to delete the file
        const fileId = file.previewElement.querySelector(".dz-remove").dataset.fileId;
        if (fileId) {
            fetch(`/teamflow/attachments/delete/${fileId}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    console.log(`File deleted: ${file.name}`);
                })
                .catch((error) => {
                    console.error("Error deleting file:", error);
                });
        }
    });
};

const tinyMceInit = () => {
    tinymce.init({
        selector: '#teamflow-activity-editor',
        plugins: 'lists link image',
        toolbar: 'bold italic | bullist numlist | link image', // Restrict toolbar to desired features
        menubar: false, // Disable the menu bar if not needed
        valid_elements: 'a[href|target=_blank],strong/b,em/i,ul,ol,li,img[src|alt|width|height]', // Allow only specified tags
        image_title: true, // Allow adding a title to images
        automatic_uploads: true, // Automatically handle image uploads
        file_picker_types: 'image', // Limit file picker to images
        forced_root_block: false, // Avoid wrapping text in <p> tags
        height: 200,
        min_height: 150,
        content_style: 'body { font-size: 14px; }' // Optional: customize editor content style
    });
};

const getActivityUsers = () => {
    const container = $('#teamflow_activity_assigned_to_users');
    const _token = container.data('token');
    const route = container.data('route');

    // Make an AJAX request when the page loads
    $.ajax({
        url: route,
        type: 'GET',
        data: {
            id: id
        },
        headers: {
            'X-CSRF-TOKEN': _token
        },
        success: function (response) {
            console.log(' users: ', response);
        },
        error: function (xhr, status, error) {
            console.error("An error occurred: ", error);
            alert("Failed to load users. Please try again later.");
        }
    });
}

function renderLogs(data) {
    // Assuming 'data' is an array of log objects
    let logsHtml = '';

    data.forEach(log => {
        logsHtml += `
            <div class="row my-2">
                <div class="col-md d-flex">
                    <div class="avatar avatar-xl">
                        <img class="rounded-circle" src="${log.avatarUrl}" alt="" />
                    </div>
                    <div class="flex-1 ms-2">
                        <h6 class="fs--1 mb-0">${log.name} <span class="ms-1 text-500 fs--2">&lt;${log.email}&gt;</span></h6>
                        <p class="text-warning fs--2 mb-2">${log.position}</p>
                        <h6 class="mb-0 fs--2">${log.activity}</h6>
                    </div>
                </div>
                <div class="col-md-auto ms-auto d-flex align-items-center ps-6 ps-md-3"><small class="py-2">${log.timestamp}</small></div>
            </div>
            <hr>
        `;
    });

    // Append the generated HTML to the appropriate section in the Blade template
    $('#logs-container').html(logsHtml);
}