const viewBtns = document.querySelectorAll('.js-description-btn')
const modal = document.querySelector('.js-modal')
const modalclose = document.querySelector('.js-modal-close')
const modalContainer = document.querySelector('.js-modal-container')

function showDetailProduct() {
    modal.classList.add('open')
}
function hideDetailProduct() {
    modal.classList.remove('open')
}

for(const viewBtn of viewBtns) {
    viewBtn.addEventListener('click', showDetailProduct)
}

modalclose.addEventListener('click', hideDetailProduct)

modal.addEventListener('click', hideDetailProduct)

modalContainer.addEventListener('click', function(event) {
    event.stopPropagation()
})