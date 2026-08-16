document.addEventListener('DOMContentLoaded', function () {

    const modal = document.getElementById('bookingModal');
    const closeBtn = document.querySelector('.booking-close');

    const roomIdInput = document.getElementById('room_id');

    document.querySelectorAll('.btn-book').forEach(button => {
        button.addEventListener('click', function () {
            modal.style.display = 'block';

            const roomId = this.getAttribute('data-room-id');
            roomIdInput.value = roomId;
        });
    });

    closeBtn.addEventListener('click', function () {
        modal.style.display = 'none';
    });

});