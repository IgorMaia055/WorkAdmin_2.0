  if($(window).width() <= 700){
    document.getElementById('text_workadmin').hidden = true
    document.querySelector('.dropdown').hidden = true
    document.getElementById('upgrate').hidden = true
    document.getElementById('hamburg').hidden = false
    document.getElementById('navbar_first').hidden = true
    document.getElementById('navbar_secundary').classList = '"navbar z-3 position-fixed end-0 d-flex flex-column flex-shrink-0 bg-body-tertiary navbar-first'
    document.getElementById('rote1').innerHTML = 'Pagar'
    document.getElementById('rote2').innerHTML = 'Receber'
    document.getElementById('rote3').innerHTML = 'Pagas'
    document.getElementById('btnTimerDate').hidden = true
  }
  if($(window).width() <= 400){
    document.getElementById('text_workadmin').hidden = true
    document.querySelector('.dropdown').hidden = true
    document.getElementById('upgrate').hidden = true
    document.getElementById('hamburg').hidden = false
    document.getElementById('navbar_first').hidden = true
    document.getElementById('navbar_secundary').classList = '"navbar z-3 position-fixed end-0 d-flex flex-column flex-shrink-0 bg-body-tertiary navbar-first'
    document.getElementById('rote1').innerHTML = 'Pagar'
    document.getElementById('rote2').innerHTML = 'Receber'
    document.getElementById('rote3').innerHTML = 'Pagas'
    document.getElementById('btnTimerDate').hidden = true
  }

  function navbar_first(){
    if(document.getElementById('hamburg').value == 'on'){
      document.getElementById('navbar_first').hidden = false
      document.getElementById('hamburg').value = 'off'
      document.getElementById('hamburg').innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">'+
'<path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>'+
'</svg>'
    }else{
      document.getElementById('navbar_first').hidden = true
      document.getElementById('hamburg').value = 'on'
      document.getElementById('hamburg').innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">'+
            '<path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>'+
          '</svg>'
    }
  }