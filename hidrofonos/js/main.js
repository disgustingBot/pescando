

window.onload=()=>{
  // alert('hi there')
  // obseController.setup();
  // set_obses();
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
      let intersection = [...elemento.classList].filter(value => dont_remove.includes(value));
      elemento.classList = []
      intersection.forEach( item => { elemento.classList.add(item) });
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



const playAudioFromSelector = (selector, alt = false) => {
  let x = document.querySelector(selector);

  if(x.paused && !x.ended) {
    x.play();
  }

  else if(alt === true) {
    x.pause();
    x.currentTime = 0;
  }
}



const back_btn = () => {
  let selector = document.querySelector('.full_screen_media_option_selector');
  let is_playing = selector.classList.length > 1;

  if(is_playing) {
    let option_click = selector.querySelector(`[data-specie=${selector.classList[selector.classList.length-1]}]`);
    option_click.click();
  }

  else {
    altClassFromSelector('', '.hydrophone_main', ['hydrophone_main']);
    // altClassFromSelector('', '.general', ['general'])
  }
}



  function in_animate_screen() {
    setTimeout(() => {
      altClassFromSelector('in_animate_screen_display', '.in_animate_screen');
    }, parseFloat(500));
  }

const end_videos_reset = () => {
  let videos = document.querySelectorAll('.full_screen_media_video');
  let selector = document.querySelector('.full_screen_media_option_selector');

  videos.forEach((video) => {
    video.onended = () => {
      let specie = selector.classList[selector.classList.length - 1];
      let option_click = selector.querySelector(`[data-specie=${specie}]`);

      option_click.click();
    }
  });
}
end_videos_reset();


// const test = slug=>{
//   console.log(slug);
//   altClassFromSelector(slug, '.general', ['general'])
//   set_obses()
// }

// function stop_icon_wave_anim() {
//   let specie_sounds = document.querySelectorAll('.full_screen_media_option + audio');

//   specie_sounds.forEach((sound) => {
//     sound.addEventListener('ended', () => {
//       let option_specie = sound.previousElementSibling.dataset.specie;
//       altClassFromSelector('active', `[data-specie=${option_specie}] .wave_icon`);
//     });
//   });
// }
// stop_icon_wave_anim();
