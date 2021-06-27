

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


function in_animate_screen() {
  setTimeout(() => {
    altClassFromSelector('in_animate_screen_display', '.in_animate_screen');
    altClassFromSelector('boat_position_hidden', '.boat_position');
    altClassFromSelector('boat_type_hidden', '.boat_type');
  }, 1500);
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
