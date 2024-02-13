'use strict'

const modal = document.getElementById('modal');
const openModalButton = document.getElementById('openModalButton');

openModalButton.addEventListener('click', () => {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
});

const modalCloseButton = document.getElementById('modalCloseButton');
modalCloseButton.addEventListener('click', () => {
    modal.classList.remove('flex');
    modal.classList.add('hidden');
});



