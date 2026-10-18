import './bootstrap';
import 'bootstrap/dist/js/bootstrap.bundle';
import 'bootstrap-icons/font/bootstrap-icons.css';
import $ from 'jquery';
import DataTable from 'datatables.net-dt';

import 'datatables.net-dt/css/dataTables.dataTables.min.css';

$(document).ready(function () {
    $('#myTable').DataTable();
});

export function displaySelectedImage(event, elementId) {
    const selectedImage = document.getElementById(elementId);
    const fileInput = event.target;

    if (fileInput.files && fileInput.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            selectedImage.src = e.target.result;
        };

        reader.readAsDataURL(fileInput.files[0]);
    }
}
window.displaySelectedImage = displaySelectedImage;