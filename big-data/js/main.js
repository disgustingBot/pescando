

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






// https://stackoverflow.com/questions/30712621/pure-css3-or-svg-animated-doughnut-chart/30713212
function create_donut_graph(radius, max, data, selector, stroke = 5) {
  const donut_div = document.querySelector(selector);
  const donut_indicator = donut_div.querySelector('.donut_graph_indicator');
  const donut_deco = donut_div.querySelector('.donut_graph_deco');

  const svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
  svg.setAttribute('viewBox', '0 0 100 100');

  const perimeter = 2 * 3.14 * radius;
  const perimeter_factor = perimeter / 2 / max;
  const angle_factor = 360 / 2 / max;
  const start_angle = -180;

  let filled = 0;

  // Crea los espacios que se mostrarán en la grafica
  data.forEach((item) => {
    let angle = (filled * angle_factor) + start_angle;

    const circle = document.createElementNS("http://www.w3.org/2000/svg", "circle");
    circle.setAttribute("cx", 50);
    circle.setAttribute("cy", 50);
    circle.setAttribute("r", radius);
    circle.setAttribute("stroke", item.color);
    circle.setAttribute('stroke-dasharray', perimeter);
    circle.setAttribute('stroke-dashoffset', perimeter - (Math.abs(item.value) * perimeter_factor));
    circle.setAttribute('stroke-width', stroke);
    circle.setAttribute('fill', 'transparent');
    circle.setAttribute('transform', `rotate(${angle})`);
    circle.setAttribute('transform-origin', 'center');
    svg.appendChild(circle);

    // Rotar texto si lo hay en el html
    if(donut_deco) {
      const text_degrees = document.createElement('div');
      text_degrees.className = 'donut_graph_text';
      text_degrees.style.transform = `translateX(-50%) rotate(${angle - (start_angle) / 2}deg)`;
      
      const text_value = document.createElement('p');
      text_value.innerText = item.value;
      text_value.style.color = item.color;
      text_value.style.transform = `rotate(${-(angle - (start_angle) / 2)}deg)`;

      text_degrees.append(text_value);
      donut_deco.appendChild(text_degrees);
    }

    filled += Math.abs(item.value);
  });
  
  // Se muestra la donut grafica
  donut_div.appendChild(svg);

  // Rotar indicador si lo hay en el html
  if(!donut_indicator) { return; }

  const donut_indicator_value = parseFloat(donut_indicator.dataset.value);
  const donut_indicator_angle_factor = -start_angle / max;

  donut_indicator.style.transform = `translateX(-50%) rotate(${donut_indicator_value * donut_indicator_angle_factor + start_angle / 2}deg)`;
}



function to_radians(degrees) {
  return degrees * (Math.PI / 180);
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
