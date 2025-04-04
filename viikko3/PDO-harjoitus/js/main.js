'use strict';

const modifyButtons = document.querySelectorAll('.modify-button');
const upateModal = document.querySelector('#update-modal');


modifyButtons.forEach((button) => {
    button.addEventListener('click', () => {
        const mediaId = button.dataset.media_id;
        console.log(mediaId);
    })
})