let listElements = document.querySelectorAll('.list__button--click');
let listOptions = document.querySelectorAll('.list__button')
let listSubOptions = document.querySelectorAll('.nav__link--inside');

listElements.forEach(listElement => {
  listElement.addEventListener('click', () => {
    listElement.classList.toggle('arrow')

    let height = 0;
    let menu = listElement.nextElementSibling;
    
    if (menu.clientHeight === 0) {
      height = menu.scrollHeight;
    }
    menu.style.height = `${height}px`;           
  })
})

listSubOptions.forEach(listSubOption => {
  listSubOption.addEventListener('click', ()=> {
    let mainTable = document.querySelector('.table');
    let noTasksAdd = mainTable.querySelector('.table__content--notasks')
    
    noTasksAdd.remove();    
  })
})