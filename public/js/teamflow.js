$(document).ready(function () {
    // Init dropzone
    dropzoneInit();

    //render logs
    const container = $('#logs-container');
    const type = container.data('type');
    const id = container.data('id');
    const _token = container.data('token');
    const route = container.data('route');

    $.ajax({
        url: route,
        type: 'GET',
        data: {
            _token: _token
        },
        success: function(response) {
            console.log(' Logs: ', response);
            renderLogs(response);
        },
        error: function(xhr, status, error) {
            console.error("An error occurred: ", error);
            alert("Failed to load logs. Please try again later.");
        }
    });
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

function renderLogs(data) {
    let logsHtml = '';

    data.forEach(log => {
        logsHtml += `
            <div class="row my-2">
                <div class="col-md d-flex">
                    <div class="avatar avatar-xl">
                        <img class="rounded-circle" src="${log.creator.logo}" alt="profile" />
                    </div>
                    <div class="flex-1 ms-2">
                        <h6 class="fs--1 mb-0">${log.creator.first_name} ${log.creator.last_name}<span class="ms-1 text-500 fs--2">&lt;${log.creator.email}&gt;</span></h6>
                        <p class="text-warning fs--2 mb-2">${log.creator.role}</p>
                        <h6 class="mb-0 fs--2">${log.content}</h6>
                    </div>
                </div>
                <div class="col-md-auto ms-auto d-flex align-items-center ps-6 ps-md-3"><small class="py-2">${log.created_at}</small></div>
            </div>
            <hr>
        `;
    });

    $('#logs-container').html(logsHtml);
}