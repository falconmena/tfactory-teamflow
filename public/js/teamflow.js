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
    const Selector = {
        DROPZONE: "[teamflow-data-dropzone-attachment]",
        DZ_ERROR_MESSAGE: ".dz-error-message",
        DZ_PREVIEW: ".dz-preview",
        DZ_PROGRESS: ".dz-preview .dz-preview-cover .dz-progress",
        DZ_PREVIEW_COVER: ".dz-preview .dz-preview-cover",
    };

    const dropzones = document.querySelectorAll(Selector.DROPZONE);

    !!dropzones.length &&
        dropzones.forEach((item) => {
            if (item.dropzone) return; // Skip if already initialized

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
                        formData.append("attachable_id", document.querySelector('input[name="attachable_id"]').value);
                        formData.append("attachable_type", document.querySelector('input[name="attachable_type"]').value);
                    });
    
                    this.on("queuecomplete", function () {
                        alert("All files have been uploaded successfully!");
                    });
    
                    this.on("error", function (file, errorMessage) {
                        alert(`Error uploading file: ${errorMessage}`);
                    });
                },
            });
        });
};