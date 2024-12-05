$(document).ready(function () {
    // Init dropzone
    dropzoneInit();

    $('#teamflowForm').on('submit', function (e) {
        e.preventDefault();

        const formData = {
            data: $('#data').val(),
            _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token for security
        };

        $.ajax({
            url: $(this).data('url'), // Use dynamic URL
            type: "POST",
            data: formData,
            success: function (response) {
                alert('Data saved successfully: ' + response.message);
            },
            error: function (xhr) {
                alert('An error occurred: ' + xhr.responseText);
            }
        });
    });
});

// Attachment Dropzone
const dropzoneInit = () => {
    const dropzoneElement = document.querySelector("#teamflow-data-dropzone-attachment");
    if (dropzoneElement.dropzone) return; // Skip if already initialized

    const myDropzone = new Dropzone(dropzoneElement, {
        url: dropzoneElement.action,
        method: "POST",
        paramName: "file",
        autoProcessQueue: false, // Prevent automatic upload
        parallelUploads: 10, // Number of files processed in parallel
        maxFilesize: 20, // Max size in MB
        addRemoveLinks: true,
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
                formData.append("attachable_id", document.querySelector('input[name="attachable_id"]').value);
                formData.append("attachable_type", document.querySelector('input[name="attachable_type"]').value);
                formData.append("created_by", document.querySelector('input[name="created_by"]').value);
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
    fetch("/teamflow/attachments/recent")
        .then((response) => response.json())
        .then((files) => {
            files.forEach((file) => {
                console.log(files);
                const mockFile = { name: file.name, size: file.size };

                // Add the file to Dropzone
                myDropzone.emit("addedfile", mockFile);
                myDropzone.emit("thumbnail", mockFile, file.url); // Set preview image
                myDropzone.emit("complete", mockFile); // Mark file as complete

                // Optional: Set custom properties for future use
                mockFile.previewElement.querySelector(".dz-remove").dataset.fileId = file.id;
            });
        })
        .catch((error) => {
            console.error("Error fetching recent files:", error);
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