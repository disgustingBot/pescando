<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Pescanova Biomarine Center - Menu</title>

  <link rel="icon" type="image/vnd.microsoft.icon" href="favicon.ico" sizes="36x36">
</head>
<body>
  <style>
  body{
    background: url('images/background/fondo.jpg') no-repeat center center;
  }
  .index_body{
    display: flex;
    justify-content: center;
    width: 100%;
    height: 100vh;
  }
  .index_menu{
    list-style: none;
  }
  .index_menu_title{
    font-size: 50px;
    text-decoration: none;
    color: black;
    color: rgb(154, 183, 204);
  }
  .index_menu{
    margin: auto;
    display: grid;
    grid-gap: 1rem;
  }
  .index_menu_item{
  }
  .index_menu_link{
    font-size: 40px;
    margin: auto;
    color: rgb(154, 183, 204);
    position: relative;
  }
  .index_menu_link::before{
    content: '➜';
    position: absolute;
    top: 0;
    left: -50px;
    font-size: 40px;
  }

  </style>
  <main class="index_body">









    <ul class="index_menu">
      <h1 class="index_menu_title"><img src="images/pescanova-biomarine-center.png" width="300" height="111" alt="" title="Pescanova Biomarine Center"></h1>
      <li class="index_menu_item"><a target="_blank" class="index_menu_link" href="webadmin/">Backend access</a></li>
      <li class="index_menu_item"><a target="_blank" class="index_menu_link" href="barco/">Barcos</a></li>
      <li class="index_menu_item"><a target="_blank" class="index_menu_link" href="big-data/">Big Data</a></li>
      <li class="index_menu_item"><a target="_blank" class="index_menu_link" href="cultivo/">Cultivo</a></li>
      <li class="index_menu_item"><a target="_blank" class="index_menu_link" href="flota-y-caladeros/">Flota y caladeros</a></li>
      <li class="index_menu_item"><a target="_blank" class="index_menu_link" href="hidrofonos/">Hidrofonos</a></li>
      <li class="index_menu_item"><a target="_blank" class="index_menu_link" href="investigacion/">Investigacion</a></li>
    </ul>


  </main>
</body>
</html>
