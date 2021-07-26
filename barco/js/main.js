

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

// function in_animate_screen(e) {
//   e.preventDefault();
//   altClassFromSelector('in_animate_screen_display', '.in_animate_screen');

//   setTimeout(() => {
//     location.href = e.target.href;
//   }, 500);
// }

function anim_texts() {
  let anim_delay = 0.75;
  let texts = [...document.querySelectorAll('.shape_screen_img text')];
  texts.forEach((text) => {
    text.style.transitionDelay = `${anim_delay += 0.25}s`;
  });

  altClassFromSelector('text_show', '.shape_screen_img text');
}



// Start interactivity timer
if(typeof(redirect_time) !== 'undefined') {
  let current_time = 0;
  let is_playing_media = false;
  
  setInterval(() => {
    if(!is_playing_media) current_time++;
  
    if(current_time >= redirect_time) {
      reset_current_time();
      window.location.href = 'index.php';
    }
  }, 1000);
  
  reset_timer_events = ['click', 'touchstart']
  reset_timer_events.forEach(event => {
    window.addEventListener(event, () => {
      reset_current_time();
    });
  });
  
  // Reset current time
  const reset_current_time = () => { current_time = 0; }

  // Playing media events
  const set_playing_timer_status = (medias, events, is_playing) => {
    // Por cada video
    medias.forEach(media => {
      // Cada evento
      events.forEach(event => {
        media.addEventListener(event, () => {
         is_playing_media = is_playing;
  
         if(is_playing_media) reset_current_time();
       });
      });
    });
  }

  let videos = document.querySelectorAll('video');
  set_playing_timer_status(videos, ['play'], true);
  set_playing_timer_status(videos, ['pause', 'emptied', 'ended'], false);
}
