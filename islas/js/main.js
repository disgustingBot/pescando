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
  console.log('test');
  altClassFromSelector('', '.islands_main', ['islands_main']);
}



const end_full_video = () => {
  let video = document.querySelector('.full_video');
  event_list = ['emptied', 'ended', 'error'];
  event_list.forEach( event => {
    video.onclick = _ => {altClassFromSelector('FULL_VIDEO', '.islands_main', ['islands_main'])}
    // video.addEventListener(event, _ => {
    //   video_to_map();
    // });
  });

  if(typeof(video.lastChild.src) == 'undefined') { video_to_map() }

  function video_to_map() {
    altClassFromSelector('FULL_VIDEO', '.islands_main', ['islands_main']);
    // altClassFromSelector('ISLANDS_MAP', '.islands_main', ['islands_main']);
  }
}
end_full_video();





const clicks_islas = () => {
  let islas_btns = document.querySelectorAll('.islands_map_menu #botonera > g');

  islas_btns.forEach((isla) => {
    isla.onclick = () => {
      console.log(isla.id);
      // altClassFromSelector('ISLANDS_QUESTION', '.islands_main', ['islands_main']);
      altClassFromSelector(isla.id, '.islands_main',     ['islands_main']);
      // altClassFromSelector(isla.id, '.islands_question', ['islands_question']);
    }
  });
}
clicks_islas();




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





// Start interactivity timer
if(typeof(redirect_time) !== 'undefined') {
  let current_time = 0;
  let is_playing_media = false;

  setInterval(() => {
    if(!is_playing_media) current_time++;
    // current_time++;
    console.log(current_time+' >= '+redirect_time);

    if(current_time >= redirect_time) {
      reset_current_time();
      window.location.href = 'inc.session.end.php';
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
         console.log(event);

         if(is_playing_media) reset_current_time();
       });
      });
    });
  }
  let videos = document.querySelectorAll('video');
  set_playing_timer_status(videos, ['play'], true);
  set_playing_timer_status(videos, ['pause', 'emptied', 'ended'], false);
}
