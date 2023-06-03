$(document).ready(function () {
    $('#student-select').on('change', function (e) {
        e.preventDefault(); // Menghentikan pengiriman form secara normal
        var studentId = $(this).val(); // Mengambil ID siswa yang dipilih
        $.ajax({
            type: "GET",
            url: "/search-student", // URL untuk menangani request di Laravel
            data: {
                'student_id': studentId
            },
            success: function (response) {
                // Menampilkan hasil pencarian pada halaman
                $('#student-info').html(response);
            },
            error: function (response) {
                alert('Error: ' + response.responseText); // Menampilkan pesan error
            }
        });
    });
});
