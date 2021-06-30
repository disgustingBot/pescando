

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




var videos = document.querySelectorAll('video:not(.first_vid)');
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
  let fist_video = document.querySelector('.first_vid');

  if(screen_menu.className == 'screen_menu') {
    altClassFromSelector('first_video', '.screen_menu');
    fist_video.load();
  }

  else {

    altClassFromSelector('', '.screen_menu', ['screen_menu']);
    var videos = document.querySelectorAll('video:not(.first_vid)');
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
  // First video ended
  let first_vid = document.querySelector('.first_vid');
  first_vid.addEventListener('ended', () => {
    altClassFromSelector('first_video', '.screen_menu');
  });

  // First video not loaded
  let first_vid_source = document.querySelector('.first_vid source:last-child');

  first_vid_source.addEventListener('error', () => {
    altClassFromSelector('first_video', '.screen_menu');
  });
}


function in_animate() {
  setTimeout(() => {
    altClassFromSelector('in_animate_display', '.in_animate');
  }, 200);
}