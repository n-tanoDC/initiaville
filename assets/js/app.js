import 'bootstrap';
import '../css/app.scss';

let input = document.getElementById('project_picture');

input.addEventListener('change', function () {
    let label = document.querySelector('.custom-file-label');
    label.innerHTML = this.value;
});