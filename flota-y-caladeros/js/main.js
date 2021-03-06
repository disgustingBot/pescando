
/*
=altClassFromSelector

alternates a class from a selector of choice, for example:
<div class="someButton" onclick="altClassFromSelector('activ', '#navBar')"></div>
*/
const altClassFromSelector = ( clase, selector, dont_remove = false )=>{
  const selected = [...document.querySelectorAll(selector)];
  selected.forEach(elemento => {
    let has_class = (elemento.classList.contains(clase)) ? 1 : 0;
    // const x = d.querySelector(selector);
    // dont_remove should be an array of classes to mantain, then remove all other classes
    if(dont_remove){
      let intersection = [...elemento.classList].filter(value => dont_remove.includes(value));
      // console.log(intersection);
      elemento.classList = []
      intersection.forEach( item => { elemento.classList.add(item) });
    }

    if(has_class){
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



function out_animate_screen() {
  altClassFromSelector('in_animate_screen_display', '.in_animate_screen');
  update_media_clicks();

  setTimeout(() => {
    document.querySelector('.in_animate_screen').remove();
  }, 1000);

  // altClassFromSelector('boat_position_hidden', '.boat_position');
  // altClassFromSelector('boat_type_hidden', '.boat_type');
}

function in_animate_screen(e) {
  e.preventDefault();
  altClassFromSelector('in_animate_screen_display', '.in_animate_screen');

  setTimeout(() => {
    location.href = e.target.href;
  }, 500);
}




// const setup_video = element =>{
//   let viday = document.querySelector('.viday')
//   viday.querySelector('.viday_media').setAttribute('poster', 'images/'+element.dataset.image)
//   if (viday.querySelector('.viday_media source')) {
//     let source = viday.querySelector('.viday_media source')
//     console.log(source);
//     source.parentNode.removeChild(source);
//   }
//   let sourcery = document.createElement('source');
//   sourcery.setAttribute('src', 'videos/'+element.dataset.video);
//   viday.querySelector('.viday_media').appendChild(sourcery);
//   altClassFromSelector('active', '.viday')
// }

const update_media_clicks = () => {
  let without_videos = document.querySelectorAll('.NOT_VIDEO');
  without_videos.forEach(without_video => {
    without_video.nextElementSibling.removeAttribute("onclick");
    without_video.remove();
  });
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

const end_videos_reset = () => {
  let videos = document.querySelectorAll('.viday_media');

  videos.forEach((video) => {
    video.onended = () => {
      let viday = video.parentElement;
      let back_button = viday.querySelector('.close_boat_lightbox.back');

      back_button.click();
    }
  });
}
end_videos_reset();










































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
