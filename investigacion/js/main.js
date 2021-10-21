let is_loaded = false;

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




var videos = document.querySelectorAll('video:not(.first_video)');
videos.forEach( video => {
  video.addEventListener('ended', function() {
    video.load();
    if (video.parentElement.classList.contains('menem')) {
      altClassFromSelector('', '.screen_menu', ['screen_menu'])
    }
  })
})





const back_btn = () => {
  let screen_menu = document.querySelector('.screen_menu');
  let fist_video = document.querySelector('video.first_video');

  if(screen_menu.className == 'screen_menu') {
    altClassFromSelector('first_video', '.screen_menu');
    fist_video.load();
  }

  else {

    altClassFromSelector('', '.screen_menu', ['screen_menu']);
    var videos = document.querySelectorAll('video:not(.first_video)');
    videos.forEach( video => {
      video.load()
    });
  }
  // first_vid_init()
}






const play_video = slug => {
  if (document.querySelector('.screen_menu').classList.length == 1) {
    document.querySelector('.menem.' + slug + ' video').play()
  } else {
    document.querySelector('.menem.' + slug + ' video').load()
  }
  altClassFromSelector(slug, '.screen_menu', ['screen_menu'])
  // console.log('.menem.' + slug);
  // console.log(document.querySelector('.menem.' + slug));
  // document.querySelector('.menem .' + slug).video.play()

  // console.log(document.querySelector('.screen_menu').classList.length);
}






function first_vid_init () {
  let first_vid = document.querySelector('video.first_video');

  if(!has_video || first_vid == null) {
    window.addEventListener('load', () => {
      is_loaded = true;
      altClassFromSelector('first_video', '.screen_menu');
    });

    return;
  }

  // First video ended
  first_vid.addEventListener('ended', () => {
    altClassFromSelector('first_video', '.screen_menu');
  });

  // First video not loaded
  let first_vid_source = document.querySelector('video.first_video source:last-child');

  first_vid_source.addEventListener('error', () => {
    altClassFromSelector('first_video', '.screen_menu');
  });

  // First video start load
  first_vid.addEventListener('play', () => {
    is_loaded = true;
  });
}


// function in_animate() {
//   setTimeout(() => {
//     altClassFromSelector('in_animate_display', '.in_animate');
//   }, 200);
// }










function animate_bubbles() {
  let fish = document.querySelector('.in_screen_icon');
  let fish_styles = getComputedStyle(fish);
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
      let fish_position = fish.getBoundingClientRect();

      let bubble = document.createElement('div');
      bubble.className = "bubble";

      bubble.style.top = (fish_position.top + 100) + 'px';

      if(parseFloat(fish_styles.offsetDistance) < 55) {
        bubble.style.left = (fish_position.left + 200) + 'px';
      }

      else {
        bubble.style.left = (fish_position.left) + 'px';
      }

      animation_screen.appendChild(bubble);
      bubbles.push(bubble);

      setTimeout(() => {
        // Optimize!
        bubbles.shift().remove();
      }, 2000);

      return true;
    }

    else {
      out_animate(animation_screen);
      return false;
    }
  }
}

function out_animate(animation_screen) {
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
