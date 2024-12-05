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

window.Dropzone ? (window.Dropzone.autoDiscover = false) : "";

const dropzoneInit = () => {
    const { merge } = window._;

    const Selector = {
        DROPZONE: "#teamflow-data-dropzone-attachment",
        DZ_ERROR_MESSAGE: ".dz-error-message",
        DZ_PREVIEW: ".dz-preview",
        DZ_PROGRESS: ".dz-preview .dz-preview-cover .dz-progress",
        DZ_PREVIEW_COVER: ".dz-preview .dz-preview-cover",
    };

    const ClassName = {
        DZ_FILE_PROCESSING: "dz-file-processing",
        DZ_FILE_COMPLETE: "dz-file-complete",
        DZ_COMPLETE: "dz-complete",
        DZ_PROCESSING: "dz-processing",
    };

    const DATA_KEY = {
        OPTIONS: "options",
    };

    const Events = {
        ADDED_FILE: "addedfile",
        REMOVED_FILE: "removedfile",
        COMPLETE: "complete",
    };

    const dropzones = document.querySelector(Selector.DROPZONE);

    !!dropzones.length &&
        dropzones.forEach((item) => {
            let data = {};
            let token = $('meta[name="csrf-token"]').attr('content');
            let recents_url = $(Selector.DROPZONE).data('data-recent-route');
            console.log(recents_url);
            let attachable_id = document.querySelector('input[name="attachable_id"]').value;
            let attachable_type = document.querySelector('input[name="attachable_type"]').value;
            let created_by = document.querySelector('input[name="created_by"]').value;
            $.ajax({
                url: recents_url,
                type: 'GET',
                data: {
                    _token: token,
                    attachable_id,
                    attachable_type
                },
                success: function (response) {
                    data = response;
                    console.log(response);
                }
            });

            console.log(data);

            const options = merge(
                {
                    url: item.action,
                    method: "POST",
                    paramName: "file",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                    },
                    addRemoveLinks: false,
                    previewsContainer: item.querySelector(Selector.DZ_PREVIEW),
                    previewTemplate: item.querySelector(Selector.DZ_PREVIEW)
                        .innerHTML,
                    thumbnailWidth: null,
                    thumbnailHeight: null,
                    maxFilesize: 20,
                    autoProcessQueue: false,
                    filesizeBase: 1000,
                    init: function init() {
                        const thisDropzone = this;

                        thisDropzone.on("sending", function (file, xhr, formData) {
                            // Append additional data to the request
                            formData.append("attachable_id", document.querySelector('input[name="attachable_id"]').value);
                            formData.append("attachable_type", document.querySelector('input[name="attachable_type"]').value);
                            formData.append("created_by", document.querySelector('input[name="created_by"]').value);
                        });

                        if (data.length) {
                            data.forEach((v) => {
                                const mockFile = { name: v.name, size: v.size };
                                thisDropzone.options.addedfile.call(
                                    thisDropzone,
                                    mockFile
                                );
                                thisDropzone.options.thumbnail.call(
                                    thisDropzone,
                                    mockFile,
                                    `${v.url}/${v.name}`
                                );
                            });
                        }

                        thisDropzone.on(
                            Events.ADDED_FILE,
                            function addedfile() {
                                if ("maxFiles" in userOptions) {
                                    if (
                                        userOptions.maxFiles === 1 &&
                                        item.querySelectorAll(
                                            Selector.DZ_PREVIEW_COVER
                                        ).length > 1
                                    ) {
                                        item.querySelector(
                                            Selector.DZ_PREVIEW_COVER
                                        ).remove();
                                    }
                                    if (
                                        userOptions.maxFiles === 1 &&
                                        this.files.length > 1
                                    ) {
                                        this.removeFile(this.files[0]);
                                    }
                                }
                            }
                        );
                    },
                    error(file, message) {
                        if (file.previewElement) {
                            file.previewElement.classList.add("dz-error");
                            if (typeof message !== "string" && message.error) {
                                message = message.error;
                            }
                            for (let node of file.previewElement.querySelectorAll(
                                "[data-dz-errormessage]"
                            )) {
                                node.textContent = message;
                            }
                        }
                    },
                },
                userOptions
            );
            // eslint-disable-next-line
            item.querySelector(Selector.DZ_PREVIEW).innerHTML = "";

            const dropzone = new window.Dropzone(item, options);

            dropzone.on(Events.ADDED_FILE, () => {
                if (item.querySelector(Selector.DZ_PREVIEW_COVER)) {
                    item.querySelector(
                        Selector.DZ_PREVIEW_COVER
                    ).classList.remove(ClassName.DZ_FILE_COMPLETE);
                }
                item.classList.add(ClassName.DZ_FILE_PROCESSING);
            });
            dropzone.on(Events.REMOVED_FILE, () => {
                if (item.querySelector(Selector.DZ_PREVIEW_COVER)) {
                    item.querySelector(
                        Selector.DZ_PREVIEW_COVER
                    ).classList.remove(ClassName.DZ_PROCESSING);
                }
                item.classList.add(ClassName.DZ_FILE_COMPLETE);
            });
            dropzone.on(Events.COMPLETE, () => {
                if (item.querySelector(Selector.DZ_PREVIEW_COVER)) {
                    item.querySelector(
                        Selector.DZ_PREVIEW_COVER
                    ).classList.remove(ClassName.DZ_PROCESSING);
                }

                item.classList.add(ClassName.DZ_FILE_COMPLETE);
            });
        });
};

// // Attachment Dropzone
// const dropzoneInit = () => {
//     const dropzoneElement = document.querySelector("#teamflow-data-dropzone-attachment");
//     if (dropzoneElement.dropzone) return; // Skip if already initialized

//     const myDropzone = new Dropzone(dropzoneElement, {
//         url: dropzoneElement.action,
//         method: "POST",
//         paramName: "file",
//         autoProcessQueue: false, // Prevent automatic upload
//         parallelUploads: 10, // Number of files processed in parallel
//         maxFilesize: 20, // Max size in MB
//         headers: {
//             "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
//         },
//         init: function () {
//             const submitButton = document.querySelector("#submit-button");

//             submitButton.addEventListener("click", (e) => {
//                 e.preventDefault();

//                 if (this.getQueuedFiles().length > 0) {
//                     this.processQueue(); // Manually trigger file upload
//                 } else {
//                     alert("No files to upload.");
//                 }
//             });

//             this.on("sending", function (file, xhr, formData) {
//                 // Append additional data to the request
//                 formData.append("attachable_id", document.querySelector('input[name="attachable_id"]').value);
//                 formData.append("attachable_type", document.querySelector('input[name="attachable_type"]').value);
//                 formData.append("created_by", document.querySelector('input[name="created_by"]').value);
//             });

//             this.on("queuecomplete", function () {
//                 alert("All files have been uploaded successfully!");
//             });

//             this.on("error", function (file, errorMessage) {
//                 alert(`Error uploading file: ${errorMessage}`);
//             });
//         },
//     });

//     // Handle file removal
//     myDropzone.on("removedfile", function (file) {
//         // Optional: Perform an AJAX request to delete the file
//         const fileId = file.previewElement.querySelector(".dz-remove").dataset.fileId;
//         if (fileId) {
//             fetch(`/teamflow/attachments/delete/${fileId}`, {
//                 method: "DELETE",
//                 headers: {
//                     "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
//                 },
//             })
//                 .then((response) => response.json())
//                 .then((data) => {
//                     console.log(`File deleted: ${file.name}`);
//                 })
//                 .catch((error) => {
//                     console.error("Error deleting file:", error);
//                 });
//         }
//     });
// };