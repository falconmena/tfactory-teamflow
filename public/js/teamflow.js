$(document).ready(function () {
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

    //render logs
    $('#logs').on('load', function (e) {
        e.preventDefault();
        const formData = {
            data: [$('#notable').attr('data-notable-id'), $('#notable').attr('data-notable-type')],
            _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token for security
        };

        $.ajax({
            url: $(this).attr('data-action'),
            type: "POST",
            data: formData,
            success: function (response) {
                alert('Data loaded successfully: ' + response.message);
            },
            error: function (xhr) {
                alert('An error occurred: ' + xhr.responseText);
            }
        });
    });
});
