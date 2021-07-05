let is_loaded = false;

window.onload=()=>{
  // alert('hi there')
  // obseController.setup();
  // set_obses();
  is_loaded = true;
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
    x.load();
    // x.pause();
    // x.currentTime = 0;
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



  // function in_animate_screen() {
  //   setTimeout(() => {
  //     altClassFromSelector('in_animate_screen_display', '.in_animate_screen');
  //   }, parseFloat(500));
  // }

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




  
function animate_bubbles() {
  let octopus = document.querySelector('.in_screen_icon');
  let animation_screen = document.querySelector('.in_animate_screen');
  let bubbles = new Array();

  // https://stackoverflow.com/questions/29971898/how-to-create-an-accurate-timer-in-javascript
  let interval = 500; // ms
  let expected = Date.now() + interval;

  setTimeout(step, interval);

  function step() {
    let dt = Date.now() - expected; // the drift (positive for overshooting)
    if (dt > interval) {
      // something really bad happened. Maybe the browser (tab) was inactive?
      // possibly special handling to avoid futile "catch up" run
    }

    // do what is to be done
    else if(create_bubbles()) {
      expected += interval;
      setTimeout(step, Math.max(0, interval - dt)); // take into account drift
    }
  }

  function create_bubbles() {
    if(!is_loaded) {
      let octopus_position = octopus.getBoundingClientRect();

      let bubble = document.createElement('div');
      bubble.className = "bubble";

      bubble.style.top = (octopus_position.top + 100) + 'px';
      bubble.style.left = (octopus_position.left + 100) + 'px';
      
      animation_screen.appendChild(bubble);
      bubbles.push(bubble);

      setTimeout(() => {
        // Optimize!
        bubbles.shift().remove();
      }, 2000);

      return true;
    }

    else {
      out_animate_screen(animation_screen);
      return false;
    }
  }
}


function out_animate_screen(animation_screen) {
  altClassFromSelector('in_animate_screen_display', '.in_animate_screen');
  
  setTimeout(() => {
    animation_screen.remove();
  }, 1000);
}

