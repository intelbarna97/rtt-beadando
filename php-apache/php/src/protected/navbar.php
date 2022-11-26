    <HTML>
    <head>
    <script>
      function getCookie(cname) 
      {
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');
        for(let i = 0; i <ca.length; i++) {
          let c = ca[i];
          while (c.charAt(0) == ' ') {
            c = c.substring(1);
          }
          if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
          }
        }
        return "";
      }
        function darkMode()
        {
          
            const cb = document.querySelector('#darkModeSwitch');
            if(cb.checked)
            {
              
              document.cookie = "dark=on";
              checkCookie() 
            }
            else 
            {
              document.cookie = "dark=off";
              checkCookie() 
            }
        }
        function checkCookie() 
        {
          let darkmode = getCookie("dark");
          if(darkmode == "on") 
          {
            console.log("ON");
            document.getElementById("darkModeSwitch").checked = true;
            document.getElementById("pageStyle").setAttribute('href',"public/dark.css");
          }
          else
          {
            console.log("OFF");
            document.getElementById("darkModeSwitch").checked = false;
            document.getElementById("pageStyle").setAttribute('href',"public/light.css");
          }
        }
    </script>
    </head>
    <body onload="checkCookie();">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="index.php?P=home">Kérdőív</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
    <li class="nav-item mr-right">
      <div class="custom-control custom-switch dark-mode">
        <input type="checkbox" class="custom-control-input dark-mode-input" id="darkModeSwitch" onclick="darkMode();" />                  
        <label class="custom-control-label dark-mode-label" for="darkModeSwitch">Sötét mód</label>
      </div>
    </li>
    <li class="nav-item">
        <a <?php if($_GET['P'] == "home"): echo "class='nav-link active'"; else: echo "class='nav-link'"; endif; ?> href="index.php?P=home">Kezdőlap</a>
      </li>
      
      <?php if($_SESSION!= NULL): ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php
          $query = "SELECT username FROM users WHERE uid=" . $_SESSION["uid"];
          
          $result = classList($query);
          
          echo $result[0]["username"];

          ?>
          
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          
          <a <?php if($_GET['P'] == "profile"): echo "class='dropdown-item active'"; else: echo "class='dropdown-item'"; endif; ?> href="index.php?P=profile">Profilom</a>
          <a <?php if($_GET['P'] == "tovabbifunkciok"): echo "class='dropdown-item active'"; else: echo "class='dropdown-item'"; endif; ?> href="index.php?P=tovabbifunkciok">További funkciók...</a>

        </div>

      </li>
      <?php endif; ?>


        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Témakörök
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a <?php if($_GET['P'] == "answerJustSurvey"): echo "class='dropdown-item active'"; else: echo "class='dropdown-item'"; endif; ?> href="index.php?P=answerJustSurvey">Új kérdőív megválaszolása</a>
          <a <?php if($_GET['P'] == "answerSurvey"): echo "class='dropdown-item active'"; else: echo "class='dropdown-item'"; endif; ?> href="index.php?P=answerSurvey">Új témakör megválaszolása</a>
          <?php if($_SESSION != NULL): ?>
          <a <?php if($_GET['P'] == "topics"): echo "class='dropdown-item active'"; else: echo "class='dropdown-item'"; endif; ?> href="index.php?P=topics">Témakörök megtekintése</a>
          <a <?php if($_GET['P'] == "completedSurveys"): echo "class='dropdown-item active'"; else: echo "class='dropdown-item'"; endif; ?> href="index.php?P=completedSurveys">Kitöltött kérdőívek megjelenítése</a>
          <a <?php if($_GET['P'] == "averages"): echo "class='dropdown-item active'"; else: echo "class='dropdown-item'"; endif; ?> href="index.php?P=averages">Átlagok</a>
          <a <?php if($_GET['P'] == "statistics"): echo "class='dropdown-item active'"; else: echo "class='dropdown-item'"; endif; ?> href="index.php?P=statistics">Statisztika</a>
          <?php endif; ?>
        </div>
      </li>
      <?php if($_SESSION == NULL): ?>
      <li class="nav-item">
        <a <?php if($_GET['P'] == "login"): echo "class='nav-link active'"; else: echo "class='nav-link'"; endif; ?> href="index.php?P=login">Bejelentkezés</a>
      </li>
      <li class="nav-item">
        <a <?php if($_GET['P'] == "register"): echo "class='nav-link active'"; else: echo "class='nav-link'"; endif; ?> href="index.php?P=register">Regisztráció</a>
      </li>
      <?php endif; ?>
      <?php
        if($_SESSION!=NULL && $_SESSION["permission"] > 0): ?>
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Admin
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          
          <a <?php if($_GET['P'] == "newSurveyUpload"): echo "class='dropdown-item active'"; else: echo "class='dropdown-item'"; endif; ?> href="index.php?P=newSurveyUpload">Új kérdőív feltöltése</a>
          <a <?php if($_GET['P'] == "addNewQuestion"): echo "class='dropdown-item active'"; else: echo "class='dropdown-item'"; endif; ?> href="index.php?P=addNewQuestion">Új kérdés hozzáadása</a>
          <a <?php if($_GET['P'] == "listUser"): echo "class='dropdown-item active'"; else: echo "class='dropdown-item'"; endif; ?> href="index.php?P=listUser">Felhasználók szerkesztése</a>
        </div>
      </li>
      <?php endif; ?>
      <?php if($_SESSION != NULL): ?>
      <li class="nav-item">
      <a <?php if($_GET['P'] == "editUser"): echo "class='nav-link active'"; else: echo "class='nav-link'"; endif; ?>  href="index.php?P=editUser">Adataim <span>[<?php echo $_SESSION["felhasznalonev"]; if($_SESSION["permission"] == 0): echo " - user"; elseif($_SESSION["permission"] == 1): echo " - admin";  else: echo " - owner"; endif;  ?>]</span></a>
      </li>
      
      
      <li class="nav-item">
        <a class="nav-link" href="index.php?P=logout">Kijelentkezés</a>
      </li>
      <?php endif; ?>
    </ul>
  </div>
</nav>
  
    </body>
</html>
        
    