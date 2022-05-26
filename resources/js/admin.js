const { default: Axios } = require('axios');
import './bootstrap';

const btnSlugger = document.querySelector('#btn-slugger');
if (btnSlugger) {
    btnSlugger.addEventListener('click', function () {
        const eleSlug = document.querySelector('#slug');
        const title = document.querySelector('#title').value;

        Axios.post('/admin/slugger', {
            originalStr: title,
        })
            .then(function (response) {
                eleSlug.value = response.data.slug;
            })

        console.log(title);
        console.log(response.data.title);
    });
}




const overlay = document.querySelector('.overlay');
if (overlay) {
    const form = overlay.querySelector('.form');

    document.querySelectorAll('.btn_delete').forEach(button => {
        button.addEventListener('click', function () {
            overlay.classList.remove('d-none');
        });
    });


    document.getElementById('btn-no').addEventListener('click', function () {
        form.action = '';
        overlay.classList.add('d-none');
    })

}