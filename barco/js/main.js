

window.onload=()=>{
  // alert('hi there')
}


/*
=altClassFromSelector

alternates a class from a selector of choice, for example:
<div class="someButton" onclick="altClassFromSelector('activ', '#navBar')"></div>
*/
const altClassFromSelector = ( clase, selector, dont_remove = false )=>{
  const selected = [...document.querySelectorAll(selector)];
  selected.forEach(elemento => {
    // const x = d.querySelector(selector);
    // dont_remove should be an array of classes to mantain, then remove all other classes
    if(dont_remove){
      elemento.classList.forEach( item =>{
        if( dont_remove.findIndex( element => element == item) == -1 && item!=clase ){
          elemento.classList.remove(item);
        }
      });
    }

    if(elemento.classList.contains(clase)){
      if(dont_remove){
        if( dont_remove.findIndex( element => element == clase) == -1 ){
          elemento.classList.remove(clase)
        }
      } else {
        elemento.classList.remove(clase)
      }
    }else{
      if(clase){
        elemento.classList.add(clase)
      }
    }
  })
}








const back_btn = () => {
  altClassFromSelector('', '.shape_screen', ['shape_screen'])
  let remover = document.querySelectorAll('.boats_screen_boat')
  remover.forEach( x => {
    if (x.querySelector('svg')) { x.querySelector('svg').remove() }
  });

}


let letterController = {
  select: letter =>{
    // console.log(letter);
    altClassFromSelector(letter, '.luke', ['luke'])
  }
}



function out_animate_screen() {
  altClassFromSelector('in_animate_screen_display', '.in_animate_screen');
  // anim_texts();

  setTimeout(() => {
    // Delete icon animated
    let in_animate_screen = document.querySelector('.in_animate_screen');
    in_animate_screen.remove();
  }, 1000);
}

function in_animate_screen(e) {
  e.preventDefault();
  altClassFromSelector('in_animate_screen_display', '.in_animate_screen');

  setTimeout(() => {
    location.href = e.target.href;
  }, 500);
}

function anim_texts() {
  let anim_delay = 0.75;
  let texts = [...document.querySelectorAll('.shape_screen_img text')];
  texts.forEach((text) => {
    text.style.transitionDelay = `${anim_delay += 0.25}s`;
  });

  altClassFromSelector('text_show', '.shape_screen_img text');
}



// Inactivity redirect
// Redirecciona en el tiempo dado (en segundos)
function start_inactivity_redirect(redirect_time) {
  return setTimeout(() => {
    window.location.href = 'index.php';
  }, redirect_time * 1000);
}

// Limpia el tiempo del setTimeout y lo vuelve a iniciar con el nuevo tiempo dado
function reset_inactivity_redirect(inactivity_timer, redirect_time) {
  window.clearTimeout(inactivity_timer);
  return start_inactivity_redirect(redirect_time);
}
