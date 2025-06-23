// Fungsi untuk menampilkan konfirmasi sebelum menghapus
function confirmDelete(id, type) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: `Data ${type} akan dihapus permanen!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `hapus.php?id=${id}&type=${type}`;
        }
    });
}

// Fungsi untuk menampilkan waktu countdown
function startTimer(duration, display) {
    let timer = duration, minutes, seconds;
    const interval = setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        if (--timer < 0) {
            clearInterval(interval);
            Swal.fire({
                title: 'Waktu Habis!',
                text: 'Waktu pengerjaan telah habis, jawaban akan dikirim otomatis',
                icon: 'warning'
            }).then(() => {
                document.querySelector('form').submit();
            });
        }
    }, 1000);
}

// Inisialisasi timer jika ada elemen dengan class timer
const timerDisplay = document.querySelector('.timer');
if (timerDisplay) {
    const timeInMinutes = 30; // 30 menit
    startTimer(timeInMinutes * 60, timerDisplay);
}

// Inisialisasi chart jika ada
const ctx = document.getElementById('hasilChart');
if (ctx) {
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Benar', 'Salah'],
            datasets: [{
                data: [8, 2],
                backgroundColor: [
                    '#28a745',
                    '#dc3545'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}